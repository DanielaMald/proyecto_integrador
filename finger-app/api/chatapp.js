import React, { useRef } from 'react';
import { View, Text, StyleSheet, TextInput, TouchableOpacity, WebView } from 'react-native';

export default function ChatScreen() {
  const webViewRef = useRef(null);

  const sendMessage = () => {
    // Obtener el mensaje del input
    const message = document.getElementById('messageInput').value;

    // Limpiar el input después de obtener el mensaje
    document.getElementById('messageInput').value = '';

    // Crear el script para enviar el mensaje al WebView
    const script = `document.getElementById('messageInput').value = '${message}'; document.getElementById('sendMessageBtn').click();`;

    // Ejecutar el script en el WebView
    webViewRef.current.injectJavaScript(script);
  };

  return (
    <View style={styles.container}>
      <WebView
        ref={webViewRef}
        source={{ uri: 'tu_url_del_chat.html' }} // Reemplaza 'tu_url_del_chat.html' con la URL de tu chat HTML
      />
      <View style={styles.inputContainer}>
        <TextInput
          style={styles.input}
          placeholder="Escribe tu mensaje..."
          returnKeyType="send"
          onSubmitEditing={sendMessage}
          id="messageInput"
        />
        <TouchableOpacity style={styles.button} onPress={sendMessage}>
          <Text style={styles.buttonText}>Enviar</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  inputContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    borderTopWidth: 1,
    borderTopColor: '#ccc',
    padding: 10,
  },
  input: {
    flex: 1,
    padding: 8,
    borderRadius: 20,
    marginRight: 10,
    backgroundColor: '#fff',
  },
  button: {
    backgroundColor: '#007bff',
    paddingVertical: 10,
    paddingHorizontal: 20,
    borderRadius: 20,
  },
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
});
