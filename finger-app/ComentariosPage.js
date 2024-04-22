import { Picker } from '@react-native-picker/picker';
import React, { useEffect, useState } from 'react';
import { ScrollView, StyleSheet, Text, TextInput, TouchableOpacity, View } from 'react-native';

export default function ComentariosPage() {
  const [messages, setMessages] = useState([]);
  const [input, setInput] = useState('');
  const [selectedMateria, setSelectedMateria] = useState(null);
  const [materias, setMaterias] = useState([]);
  const [matricula, setMatricula] = useState('');
  const [grupo, setGrupo] = useState('');
  const [claveProfesor, setClaveProfesor] = useState('');

  useEffect(() => {
    fetchPerfil();
  }, []);

  const fetchPerfil = async () => {
    try {
      const response = await fetch('https://9zbklm0q-3000.usw3.devtunnels.ms/perfil');
      const data = await response.json();
      if (!response.ok) {
        throw new Error(data.error || 'No se pudo obtener el perfil del alumno');
      }
      setMatricula(data.matricula);
      fetchMaterias();
    } catch (error) {
      console.error('Error al obtener el perfil del alumno:', error);
    }
  };

  const fetchMaterias = async () => {
    try {
      const response = await fetch('https://9zbklm0q-3000.usw3.devtunnels.ms/materias-con-comentarios');
      const data = await response.json();
      // Filtrar las materias duplicadas
      const uniqueMaterias = data.filter((materia, index, self) =>
        index === self.findIndex((m) => m.id_asignatura === materia.id_asignatura)
      );
      setMaterias(uniqueMaterias);
      if (uniqueMaterias.length > 0) {
        setSelectedMateria(uniqueMaterias[0].id_asignatura); // Establecer el primer valor como la materia seleccionada por defecto
        fetchComentarios(uniqueMaterias[0].id_asignatura); // Cargar los comentarios de la primera materia por defecto
      }
    } catch (error) {
      console.error('Error al obtener las materias:', error);
    }
  };
  
  

  const fetchComentarios = async (materiaSeleccionada) => {
    try {
      const response = await fetch(`https://9zbklm0q-3000.usw3.devtunnels.ms/comentarios-estudiante/${matricula}/${materiaSeleccionada}`);
      if (!response.ok) {
        throw new Error('No se pudieron obtener los comentarios');
      }
      const data = await response.json();
      setMessages(data.comentarios || []);
    } catch (error) {
      // Limpia los mensajes en caso de error
      setMessages([]);
    }
  };
  
  const handleMessage = (data) => {
    setMessages(prevMessages => [...prevMessages, data]);
  };

  const sendMessage = async () => {
    if (input.trim() !== '') {
      try {
        await fetch('https://9zbklm0q-3000.usw3.devtunnels.ms/responder-comentario', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ 
            respuesta: input,
            id_asignatura: selectedMateria,
            id_grupo: grupo,
            clave_profesor: claveProfesor
          })
        });
        setMessages(prevMessages => [...prevMessages, { comentario: input }]);
        setInput('');
      } catch (error) {
        console.error('Error al enviar el mensaje:', error);
      }
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Comentarios del Profesor</Text>
      <View style={styles.pickerContainer}>
        <Text style={styles.pickerLabel}>Selecciona una Materia:</Text>
        <Picker
            selectedValue={selectedMateria}
            onValueChange={(itemValue, itemIndex) => {
              setSelectedMateria(itemValue);
              setGrupo(materias[itemIndex].id_grupo);
              setClaveProfesor(materias[itemIndex].clave_profesor);
              fetchComentarios(itemValue); // Llama a fetchComentarios cuando cambia la materia seleccionada
            }}
            style={styles.picker}
          >
            {materias.map((materia, index) => (
              <Picker.Item key={index} label={materia.materia} value={materia.id_asignatura} />
            ))}
          </Picker>

      </View>
      <ScrollView style={styles.messageContainer}>
        {messages.length === 0 ? (
          <Text style={styles.noCommentsText}>No tienes comentarios por revisar</Text>
        ) : (
          messages.map((msg, index) => (
            <Text key={index} style={styles.message}>{msg.comentario}</Text>
          ))
        )}
      </ScrollView>
      <View style={styles.inputContainer}>
        <TextInput
          style={styles.input}
          value={input}
          onChangeText={(text) => setInput(text)}
          placeholder="Escribe tu comentario..."
        />
        <TouchableOpacity style={styles.button} onPress={sendMessage} disabled={!selectedMateria}>
          <Text style={styles.buttonText}>Enviar</Text>
        </TouchableOpacity>
      </View>
    </View>
  );

}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#b3d9ff',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    color: '#333',
    textAlign: 'center',
  },
  pickerContainer: {
    marginBottom: 20,
    backgroundColor: '#fff',
    borderRadius: 10,
    paddingHorizontal: 10,
    paddingVertical: 5,
    elevation: 3,
  },
  pickerLabel: {
    fontSize: 16,
    marginBottom: 5,
    color: '#555',
  },
  picker: {
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 5,
  },
  messageContainer: {
    flex: 1,
    marginBottom: 20,
  },
  message: {
    fontSize: 16,
    marginBottom: 10,
    backgroundColor: '#fff',
    padding: 10,
    borderRadius: 10,
    elevation: 3,
  },
  noCommentsText: {
    fontSize: 16,
    marginBottom: 10,
    color: '#555',
    textAlign: 'center',
  },
  inputContainer: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  input: {
    flex: 1,
    height: 40,
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 5,
    padding: 10,
    marginRight: 10,
    backgroundColor: '#fff',
    elevation: 3,
  },
  button: {
    backgroundColor: '#0052cc',
    paddingVertical: 10,
    paddingHorizontal: 20,
    borderRadius: 5,
  },
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
});
