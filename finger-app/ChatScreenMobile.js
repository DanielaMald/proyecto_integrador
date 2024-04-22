import React, { useEffect, useState } from 'react';
import { GiftedChat } from 'react-native-gifted-chat';
import io from 'socket.io-client';

const socket = io('http://192.168.101.14:3000');

const ChatScreenMobile = () => {
  const [mensajes, setMensajes] = useState([]);

  useEffect(() => {
    socket.on('mensaje', (nuevoMensaje) => {
      setMensajes((anterioresMensajes) => GiftedChat.append(anterioresMensajes, nuevoMensaje));
    });

    return () => {
      socket.off('mensaje');
    };
  }, []);

  const enviarMensaje = async (mensajesNuevos) => {
    const mensaje = mensajesNuevos[0].text;

    console.log('Mensaje a enviar al servidor:', mensaje); // Agregar registro de depuración

    try {
      await fetch('http://192.168.101.14:4000/comentario', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ comentario: mensaje })
      });
      console.log('Comentario enviado al servidor');
    } catch (error) {
      console.error('Error al enviar el comentario al servidor:', error);
    }

    socket.emit('mensaje', mensajesNuevos);
  };

  return <GiftedChat messages={mensajes} onSend={enviarMensaje} user={{ _id: 1 }} />;
};

export default ChatScreenMobile;