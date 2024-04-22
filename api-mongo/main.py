from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pymongo import MongoClient
from datetime import datetime
from pydantic import BaseModel
from bson import ObjectId

app = FastAPI()

# Configure CORS middleware
origins = [
    "http://127.0.0.1:5000",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# MongoDB connection
client = MongoClient("mongodb://localhost:27017/")
db = client["visitantes"]
collection = db["visitantes"]

class Visitante(BaseModel):
    nombre: str
    appaterno: str
    apmaterno: str
    hora_entrada: datetime = None
    hora_salida: datetime = None
    motivo: str
    dispositivo: str

@app.post("/visitantes-insertar")
async def create_visitante(visitante: Visitante):
    visitante_data = visitante.dict()
    # Si hora_entrada no está presente, establecerla en la hora actual
    if not visitante_data.get("hora_entrada"):
        visitante_data["hora_entrada"] = datetime.now()
    # Si hora_salida no está presente, establecerla en la hora actual
    if not visitante_data.get("hora_salida"):
        visitante_data["hora_salida"] = datetime.now()
    result = collection.insert_one(visitante_data)
    return {"mensaje": "Visitante creado exitosamente", "id": str(result.inserted_id)}


@app.get("/visitantes")
async def obtener_visitantes():
    # Realizar una consulta a la colección para obtener todos los visitantes
    visitantes = collection.find({})
    # Convertir los resultados de la consulta en una lista de diccionarios para que sean JSON serializables
    visitantes_lista = []
    for visitante in visitantes:
        visitante['_id'] = str(visitante['_id'])  # Convertir ObjectId a str para serialización JSON
        visitantes_lista.append(visitante)
    # Devolver la lista de visitantes
    return visitantes_lista


@app.patch("/visitantes-actualizar/{visitante_id}")
async def update_visitante(visitante_id: str):
    # Convertir el ID del visitante a un ObjectId
    visitante_obj_id = ObjectId(visitante_id)
    # Obtener la hora actual del sistema
    hora_salida = datetime.now()
    # Realizar la actualización en la base de datos
    result = collection.update_one(
        {"_id": visitante_obj_id},
        {"$set": {"hora_salida": hora_salida}}
    )
    # Verificar si se actualizó correctamente
    if result.modified_count == 1:
        return {"mensaje": "Hora de salida del visitante actualizada exitosamente"}
    return {"mensaje": "No se pudo actualizar la hora de salida del visitante"}
@app.delete("/visitantes-eliminar/{visitante_id}")
async def delete_visitante(visitante_id: str):
    # Convertir el ID del visitante a un ObjectId
    visitante_obj_id = ObjectId(visitante_id)
    # Realizar la eliminación en la base de datos
    result = collection.delete_one({"_id": visitante_obj_id})
    # Verificar si se eliminó correctamente
    if result.deleted_count == 1:
        return {"mensaje": "Visitante eliminado exitosamente"}
    return {"mensaje": "No se pudo eliminar el visitante"}
@app.get("/visitantes-buscar/{nombre}")
async def buscar_visitante(nombre: str):
    # Realizar una consulta a la colección para obtener el visitante con el nombre especificado
    visitante = collection.find_one({"nombre": nombre})
    # Verificar si se encontró el visitante
    if visitante:
        visitante['_id'] = str(visitante['_id'])
        return visitante
    raise HTTPException(status_code=404, detail="Visitante no encontrado")
