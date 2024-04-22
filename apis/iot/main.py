import mysql.connector
import fastapi
from fastapi.middleware.cors import CORSMiddleware
from fastapi import HTTPException, Path
from pydantic import BaseModel
class Alumno(BaseModel):
    matricula: str
    nombre: str
    primerApellido: str
    segundoApellido: str
    email: str
    huella: str
    
# Definir un modelo para la actualización de la huella digital
class ActualizacionHuella(BaseModel):
    huella: str
# Create a connection to the MySQL database
db_connection = mysql.connector.connect(
    host="localhost",
    user="root",
    password="12345",
    database="efi100cia2"
)

app = fastapi.FastAPI()

led_state = 0  # Estado inicial del LED
# Configure CORS middleware
app.add_middleware(
    CORSMiddleware,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def get_estudiantes():
    try:
        with db_connection.cursor() as cursor:
            cursor.execute("SELECT * FROM estudiantes_inscritos")
            estudiantes = cursor.fetchall()
        return estudiantes
    except mysql.connector.Error as e:
        # Manejar cualquier error de la base de datos
        raise HTTPException(status_code=500, detail="Error de base de datos")

@app.patch("/estudiantes/{matricula}/{huella}")
async def actualizar_huella(matricula: str, huella: str):
    try:
        with db_connection.cursor() as cursor:
            # Verificar si el alumno existe
            cursor.execute("SELECT * FROM estudiantes_inscritos WHERE matricula = %s", (matricula,))
            alumno_existente = cursor.fetchone()
            if not alumno_existente:
                raise HTTPException(status_code=404, detail="Alumno no encontrado")

            # Actualizar la huella digital del alumno
            cursor.execute("UPDATE estudiantes_inscritos SET huella = %s WHERE matricula = %s",
                           (huella, matricula))
            db_connection.commit()

        return {"mensaje": "Huella digital actualizada exitosamente"}
    except mysql.connector.Error as e:
        # Manejar cualquier error de la base de datos
        raise HTTPException(status_code=500, detail="Error de base de datos")
@app.patch("/asistencias/{huella}")
async def asitencia_huella(huella: str):
    try:
        with db_connection.cursor() as cursor:
            # Verify if the student exists
            cursor.execute("SELECT matricula FROM estudiantes_inscritos WHERE huella = %s", (huella,))
            alumno_existente = cursor.fetchone()
            if not alumno_existente:
                raise HTTPException(status_code=404, detail="Alumno no encontrado")
            
            # Insert or update attendance record
            cursor.execute("INSERT INTO asistencias (matricula, asistencia, fecha, hora_entrada, clave_profesor, id_asignatura, id_grupo) VALUES (%s, 1, CURDATE(), CURTIME(), '1234567890', %s, %s) ON DUPLICATE KEY UPDATE asistencia = 1, fecha = CURDATE(), hora_entrada = CURTIME()",
                           (alumno_existente[0], 1, 1))
            db_connection.commit()
        return {"mensaje": "Asistencia registrada exitosamente para:", "matricula": alumno_existente}
    except mysql.connector.Error as e:
        # Handle any database errors
        raise HTTPException(status_code=500, detail="Error de base de datos")
@app.post("/nuevo_estudiante")
async def nuevo_estudiante(matricula: int, nombre: str, primerApellido: str, segundoApellido: str, email: str, huella: int):
    id_grupo = 1
    try:
        with db_connection.cursor() as cursor:
            cursor.execute("INSERT INTO estudiantes_inscritos (matricula, nombre, apellido1, apellido2, correo, huella, id_grupo) VALUES (%s, %s, %s, %s, %s, %s, 1)",(matricula, nombre, primerApellido, segundoApellido, email, huella))
            db_connection.commit()
            return {"mensaje": "Estudiante registrado exitosamente"}
    except mysql.connector.Error as e:
        # Handle any database errors
        raise HTTPException(status_code=500, detail="Error de base de datos")

# Definir el endpoint para registrar la asistencia del estudiante
@app.post("/asistencia_aula1/{huella}")
async def registrar_asistencia(huella: str):
    try:
        with db_connection.cursor() as cursor:
            # Insertar registro de asistencia en la tabla 'checar'
            cursor.execute("INSERT INTO checar (huella, id_salon, fecha, hora) VALUES (%s, 1, CURDATE(), CURTIME())", (huella,))
            db_connection.commit()  # Confirmar la transacción

            # Verificar si el estudiante existe
            cursor.execute("SELECT matricula, id_grupo FROM estudiantes_inscritos WHERE huella = %s", (huella,))
            alumno_existente = cursor.fetchone()
            if not alumno_existente:
                raise HTTPException(status_code=404, detail="Alumno no encontrado")
            
            # Insertar o actualizar registro de asistencia en la tabla 'asistencias'
            cursor.execute("INSERT INTO asistencias (matricula, asistencia, fecha, hora_entrada, clave_profesor, id_asignatura, id_grupo) \
                            VALUES (%s, 1, CURDATE(), CURTIME(), '1234567890',1, %s) \
                            ON DUPLICATE KEY UPDATE asistencia = 1, fecha = CURDATE(), hora_entrada = CURTIME()", (alumno_existente[0], alumno_existente[1]))
            
            db_connection.commit()  # Confirmar la transacción
            
        # Imprimir la huella digital recibida en la ruta
        print("Huella digital recibida:", huella)
        
        return {"mensaje": "Asistencia registrada exitosamente en la AULA1 para:", "matricula": alumno_existente[0]}
    
    except mysql.connector.Error as e:
        # Manejar errores de la base de datos
        raise HTTPException(status_code=500, detail="Error de base de datos")
@app.post("/asistencia_aula2/{huella}")
async def registrar_asistencia(huella: str):
    try:
        with db_connection.cursor() as cursor:
            # Insertar registro de asistencia en la tabla 'checar'
            cursor.execute("INSERT INTO checar (huella, id_salon, fecha, hora) VALUES (%s, 2, CURDATE(), CURTIME())", (huella,))
            db_connection.commit()  # Confirmar la transacción

            # Verificar si el estudiante existe
            cursor.execute("SELECT matricula, id_grupo FROM estudiantes_inscritos WHERE huella = %s", (huella,))
            alumno_existente = cursor.fetchone()
            if not alumno_existente:
                raise HTTPException(status_code=404, detail="Alumno no encontrado")
            
            # Insertar o actualizar registro de asistencia en la tabla 'asistencias'
            cursor.execute("INSERT INTO asistencias (matricula, asistencia, fecha, hora_entrada, clave_profesor, id_asignatura, id_grupo) \
                            VALUES (%s, 1, CURDATE(), CURTIME(), '1234567890',1, %s) \
                            ON DUPLICATE KEY UPDATE asistencia = 1, fecha = CURDATE(), hora_entrada = CURTIME()", (alumno_existente[0], alumno_existente[1]))
            
            db_connection.commit()  # Confirmar la transacción
            
        # Imprimir la huella digital recibida en la ruta
        print("Huella digital recibida:", huella)
        
        return {"mensaje": "Asistencia registrada exitosamente en AULA2 para:", "matricula": alumno_existente[0]}
    
    except mysql.connector.Error as e:
        # Manejar errores de la base de datos
        raise HTTPException(status_code=500, detail="Error de base de datos")