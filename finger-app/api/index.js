const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const session = require('express-session');
const crypto = require('crypto');
const fetch = require('node-fetch');

const app = express();
const port = 3000;

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '12345',
  database: 'efi100cia2'
});

connection.connect((err) => {
  if (err) {
    console.error('Error de conexión a la base de datos:', err);
    return;
  }
  console.log('Conexión exitosa a la base de datos');
});

const sessionSecret = crypto.randomBytes(32).toString('hex');

app.use(bodyParser.json());
app.use(session({
  secret: sessionSecret,
  resave: false,
  saveUninitialized: false
}));

app.post('/principal', (req, res) => {
  if (!req.body || !req.body.matricula) {
    console.error('Datos de inicio de sesión incorrectos');
    return res.status(400).json({ error: 'Datos de inicio de sesión incorrectos' });
  }

  const { matricula } = req.body;
  const query = "SELECT matricula FROM estudiantes_inscritos WHERE matricula = ?";

  connection.query(query, [matricula], (err, results) => {
    if (err) {
      console.error('Error al ejecutar la consulta:', err);
      return res.status(500).json({ error: 'Error interno del servidor' });
    }
    if (results.length === 1) {
      console.log('Inicio de sesión exitoso');
      req.session.loggedin = true;
      req.session.matricula = matricula;
      return res.status(200).json({ message: 'Inicio de sesión exitoso' });
    } else {
      console.error('Credenciales incorrectas');
      return res.status(401).json({ error: 'Credenciales incorrectas' });
    }
  });
});

app.get('/perfil', (req, res) => {
  if (!req.session || !req.session.loggedin) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const matricula = req.session.matricula;

  const query = "SELECT nombre, matricula FROM estudiantes_inscritos WHERE matricula = ?";

  connection.query(query, [matricula], (err, results) => {
    if (err) {
      console.error('Error al obtener el perfil del alumno:', err);
      return res.status(500).json({ error: 'Error interno del servidor' });
    }
    if (results.length === 1) {
      console.log('Perfil del alumno encontrado');
      return res.status(200).json(results[0]);
    } else {
      console.error('Perfil del alumno no encontrado');
      return res.status(404).json({ error: 'Perfil del alumno no encontrado' });
    }
  });
});

app.get('/materias', (req, res) => {
  if (!req.session || !req.session.loggedin || !req.session.matricula) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const matricula = req.session.matricula;

  const queryMaterias = `
    SELECT DISTINCT A.id_asignatura, A.nombre AS materia
    FROM comentarios_profesor_alumno C 
    JOIN asignaturas A ON C.id_asignatura = A.id_asignatura 
    WHERE C.matricula = ?;
  `;

  connection.query(queryMaterias, [matricula], (errMaterias, resultMaterias) => {
    if (errMaterias) {
      console.error('Error al obtener las materias:', errMaterias);
      return res.status(500).json({ error: 'Error interno del servidor al obtener las materias' });
    }

    console.log('Materias obtenidas');
    return res.status(200).json(resultMaterias);
  });
});

app.post('/comentario', (req, res) => {
  if (!req.session || !req.session.loggedin || !req.session.matricula) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const matricula = req.session.matricula;
  const { comentario } = req.body;

  const queryInsertComentario = `
    INSERT INTO comentarios_profesor_alumno (matricula, comentario, fecha) 
    VALUES (?, ?, NOW());
  `;

  connection.query(queryInsertComentario, [matricula, comentario], (errInsertComentario, resultInsertComentario) => {
    if (errInsertComentario) {
      console.error('Error al insertar el comentario:', errInsertComentario);
      return res.status(500).json({ error: 'Error interno del servidor al insertar el comentario' });
    }

    console.log('Comentario insertado correctamente');
    return res.status(201).json({ message: 'Comentario insertado correctamente' });
  });
});


app.post('/responder-comentario', (req, res) => {
  if (!req.body || !req.body.respuesta || !req.body.id_asignatura || !req.body.id_grupo || !req.body.clave_profesor) {
    return res.status(400).json({ error: 'Datos incompletos proporcionados' });
  }

  const { respuesta, id_asignatura, id_grupo, clave_profesor } = req.body;
  const matricula = req.session.matricula;

  const query = "INSERT INTO respuestas_profesor_alumno (matricula, respuesta, id_asignatura, id_grupo, clave_profesor) VALUES (?, ?, ?, ?, ?)";

  connection.query(query, [matricula, respuesta, id_asignatura, id_grupo, clave_profesor], (err, results) => {
    if (err) {
      console.error('Error al insertar respuesta en la base de datos:', err);
      return res.status(500).json({ error: 'Error interno del servidor' });
    }
    console.log('Respuesta guardada en la base de datos');
    return res.status(200).json({ message: 'Respuesta guardada exitosamente' });
  });
});


app.get('/materias-con-comentarios', (req, res) => {
  if (!req.session || !req.session.loggedin || !req.session.matricula) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const matricula = req.session.matricula;

  const queryMateriasConComentarios = `
    SELECT A.id_asignatura, A.nombre AS materia, AM.clave_profesor, AM.id_grupo
    FROM comentarios_profesor_alumno C 
    JOIN asignaturas A ON C.id_asignatura = A.id_asignatura 
    JOIN asignacionmaterias AM ON C.id_asignatura = AM.id_asignatura 
    WHERE C.matricula = ?;
  `;

  connection.query(queryMateriasConComentarios, [matricula], (errMaterias, resultMaterias) => {
    if (errMaterias) {
      console.error('Error al obtener las materias con comentarios:', errMaterias);
      return res.status(500).json({ error: 'Error interno del servidor al obtener las materias con comentarios' });
    }

    console.log('Materias con comentarios obtenidas');
    return res.status(200).json(resultMaterias);
  });
});


app.get('/comentarios-estudiante/:matricula/:materia', (req, res) => {
  if (!req.session || !req.session.loggedin) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const { matricula, materia } = req.params;

  const query = `
    SELECT comentario
    FROM comentarios_profesor_alumno
    WHERE matricula = ? AND id_asignatura = ?
  `;

  connection.query(query, [matricula, materia], (err, results) => {
    if (err) {
      console.error('Error al obtener los comentarios:', err);
      return res.status(500).json({ error: 'Error interno del servidor al obtener los comentarios' });
    }

    console.log('Comentarios obtenidos');
    return res.status(200).json({ comentarios: results });
  });
});

// Consulta de materias del alumno ruta del voton GRUPOS
// Modificar la consulta SQL para obtener las asistencias del alumno en una materia específica
/*app.get('/asistencias', (req, res) => {
  if (!req.session || !req.session.loggedin || !req.session.matricula) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const matricula = req.session.matricula;
  const materia = req.query.materia;

  if (!materia) {
    return res.status(400).json({ error: 'Materia no especificada' });
  }

  // Modificar la consulta para filtrar las asistencias por matrícula y materia
  const queryAsistenciasPorMateria = `
    SELECT asis.asistencia,
           asis.fecha,
           asis.hora_entrada,
           grupos.nombre AS grupo
    FROM asistencias asis
    INNER JOIN grupos ON asis.id_grupo = grupos.id_grupo
    WHERE asis.matricula = ? AND asis.id_asignatura = ?
    ORDER BY asis.fecha ASC;
  `;

  connection.query(queryAsistenciasPorMateria, [matricula, materia], (errAsistencias, resultAsistencias) => {
    if (errAsistencias) {
      console.error('Error al obtener las asistencias del alumno:', errAsistencias);
      return res.status(500).json({ error: 'Error interno del servidor al obtener las asistencias del alumno' });
    }
    console.log('Asistencias del alumno obtenidas con éxito');
    return res.status(200).json({ asistencias: resultAsistencias });
  });
});


// Nueva ruta para obtener las asistencias por materia específica
app.get('/asistencias/:materia', (req, res) => {
  if (!req.session || !req.session.loggedin || !req.session.matricula) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const matricula = req.session.matricula;
  const materia = req.params.materia; // Obtener el ID de la materia de los parámetros de la URL

  if (!materia) {
    return res.status(400).json({ error: 'Materia no especificada' });
  }

  // Modificar la consulta para filtrar las asistencias por matrícula y materia
  const queryAsistenciasPorMateria = `
    SELECT asis.asistencia,
           asis.fecha,
           asis.hora_entrada,
           grupos.nombre AS grupo
    FROM asistencias asis
    INNER JOIN grupos ON asis.id_grupo = grupos.id_grupo
    WHERE asis.matricula = ? AND asis.id_asignatura = ?
    ORDER BY asis.fecha ASC;
  `;

  connection.query(queryAsistenciasPorMateria, [matricula, materia], (errAsistencias, resultAsistencias) => {
    if (errAsistencias) {
      console.error('Error al obtener las asistencias del alumno:', errAsistencias);
      return res.status(500).json({ error: 'Error interno del servidor al obtener las asistencias del alumno' });
    }
    console.log('Asistencias del alumno obtenidas con éxito');
    return res.status(200).json({ asistencias: resultAsistencias });
  });
});*/

// Consulta de materias del alumno ruta del voton GRUPOS
// Consulta de materias del alumno ruta del botón GRUPOS
app.get('/grupos', (req, res) => {
  if (!req.session || !req.session.loggedin || !req.session.matricula) {
    return res.status(401).json({ error: 'Sesión no iniciada' });
  }

  const matricula = req.session.matricula;
  const materia = req.query.materia;

  if (materia) {
    // Si se proporciona una materia seleccionada, obtener asistencias
    const queryAsistenciasPorMateria = `
      SELECT asig.nombre AS asignatura, 
             asis.asistencia,
             asis.fecha,
             grupos.nombre AS grupo
      FROM asistencias asis
      INNER JOIN asignaturas asig ON asis.id_asignatura = asig.id_asignatura
      INNER JOIN grupos ON asis.id_grupo = grupos.id_grupo
      INNER JOIN estudiantes_inscritos est ON asis.matricula = est.matricula
      WHERE est.matricula = ? AND asig.nombre = ?;
    `;

    connection.query(queryAsistenciasPorMateria, [matricula, materia], (errAsistencias, resultAsistencias) => {
      if (errAsistencias) {
        console.error('Error al obtener las asistencias del alumno:', errAsistencias);
        return res.status(500).json({ error: 'Error interno del servidor al obtener las asistencias del alumno' });
      }
      console.log('Asistencias del alumno obtenidas con éxito');
      return res.status(200).json({ asistencias: resultAsistencias });
    });
  } else {
    // Si no se proporciona una materia, obtener solo las materias
    const queryMaterias = `
      SELECT DISTINCT asig.nombre AS asignaturas
      FROM asistencias asis
      INNER JOIN asignaturas asig ON asis.id_asignatura = asig.id_asignatura
      INNER JOIN estudiantes_inscritos est ON asis.matricula = est.matricula
      WHERE est.matricula = ?;
    `;

    connection.query(queryMaterias, [matricula], (errMaterias, resultMaterias) => {
      if (errMaterias) {
        console.error('Error al obtener las materias:', errMaterias);
        return res.status(500).json({ error: 'Error interno del servidor al obtener las materias' });
      }

      console.log('Materias obtenidas con éxito');
      return res.status(200).json({ materias: resultMaterias, asistencias: [] });
    });
  }
});

//Aqui termina la ruta


app.listen(port, () => {
  console.log(`Servidor escuchando en http://localhost:${port}`);
});
