const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const mysql = require('mysql');

const app = express();
const port = 4000;

// Crear el servidor HTTP utilizando la instancia de Express
const server = http.createServer(app);

// Configurar WebSocket
const io = socketIo(server);

// Configurar conexión a la base de datos
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'efi100cia2',
});

db.connect((err) => {
  if (err) {
    console.error('Error al conectar a la base de datos: ' + err.message);
    return;
  }
  console.log('Conexión a la base de datos establecida');
});

// Manejar conexiones de WebSocket
io.on('connection', (socket) => {
  console.log('Usuario conectado');

  // Manejar mensajes del cliente
  socket.on('message', (message) => {
    console.log('Mensaje recibido:', message);

    // Guardar el mensaje en la base de datos
    const sql = `INSERT INTO respuestas_profesor_alumno (respuesta) VALUES (?)`;
    db.query(sql, [message], (err, result) => {
      if (err) {
        console.error('Error al insertar mensaje en la base de datos: ' + err.message);
        return;
      }
      console.log('Mensaje insertado en la base de datos');
    });

    // Emitir el mensaje a todos los clientes conectados
    io.emit('message', message);
  });

  // Manejar desconexiones
  socket.on('disconnect', () => {
    console.log('Usuario desconectado');
  });
});

// Iniciar el servidor
server.listen(port, () => {
  console.log(`Servidor de chat en funcionamiento en el puerto ${port}`);
});

// Ruta para guardar el mensaje en la base de datos
app.post('/comentario', (req, res) => {
  if (!req.body || !req.body.mensaje) {
    return res.status(400).json({ error: 'Mensaje no proporcionado' });
  }

  const mensaje = req.body.mensaje;

  const query = "INSERT INTO respuestas_profesor_alumno (respuesta) VALUES (?)";

  db.query(query, [mensaje], (err, results) => {
    if (err) {
      console.error('Error al insertar mensaje en la base de datos:', err);
      return res.status(500).json({ error: 'Error interno del servidor' });
    }
    console.log('Mensaje guardado en la base de datos');
    return res.status(200).json({ message: 'Mensaje guardado exitosamente' });
  });
});
