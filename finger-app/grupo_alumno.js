import { Picker } from '@react-native-picker/picker';
import React, { useEffect, useState } from 'react';
import { ActivityIndicator, FlatList, StyleSheet, Text, View } from 'react-native';

const GrupoAlumno = () => {
  const [materias, setMaterias] = useState([]);
  const [selectedMateria, setSelectedMateria] = useState('');
  const [asistencias, setAsistencias] = useState([]);
  const [loadingMaterias, setLoadingMaterias] = useState(false);
  const [loadingAsistencias, setLoadingAsistencias] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    obtenerMaterias();
  }, []);

  const obtenerMaterias = () => {
    setLoadingMaterias(true);
    fetch('https://9zbklm0q-3000.usw3.devtunnels.ms/grupos', {
      method: 'GET',
      credentials: 'include',
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Error al obtener las materias. Código de estado: ' + response.status);
        }
        return response.json();
      })
      .then(data => {
        setMaterias(data.materias.map(item => item.asignaturas));
        setLoadingMaterias(false);
      })
      .catch(error => {
        console.error('Error al obtener las materias:', error);
        setError('Error al obtener las materias. Por favor, inténtalo de nuevo más tarde.');
        setLoadingMaterias(false);
      });
  };

  const obtenerAsistencias = (materia) => {
    setLoadingAsistencias(true);
    fetch(`https://9zbklm0q-3000.usw3.devtunnels.ms/grupos?materia=${materia}`, {
      method: 'GET',
      credentials: 'include',
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Error al obtener las asistencias. Código de estado: ' + response.status);
        }
        return response.json();
      })
      .then(data => {
        setAsistencias(data.asistencias);
        setLoadingAsistencias(false);
      })
      .catch(error => {
        console.error('Error al obtener las asistencias:', error);
        setError('Error al obtener las asistencias. Por favor, inténtalo de nuevo más tarde.');
        setLoadingAsistencias(false);
      });
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Registro de Asistencias</Text>
      <Picker
        selectedValue={selectedMateria}
        style={styles.picker}
        onValueChange={(itemValue, itemIndex) => {
          setSelectedMateria(itemValue);
          obtenerAsistencias(itemValue);
        }}
      >
        <Picker.Item label="Selecciona una materia..." value="" />
        {materias.map((materia, index) => (
          <Picker.Item key={index} label={materia} value={materia} />
        ))}
      </Picker>
      <View style={styles.asistenciasContainer}>
        {loadingMaterias ? (
          <ActivityIndicator size="large" color="#FF6F00" />
        ) : (
          <>
            {loadingAsistencias ? (
              <ActivityIndicator size="large" color="#0000ff" />
            ) : (
              <FlatList
                data={asistencias}
                renderItem={({ item }) => (
                  <View style={styles.itemContainer}>
                    <Text style={styles.asistencia}>{item.asistencia === 1 ? 'ASISTIÓ' : 'FALTÓ'}</Text>
                    <Text style={styles.fecha}>{`Fecha: ${item.fecha}`}</Text>
                    <Text style={styles.grupo}>{`Grupo: ${item.grupo}`}</Text>
                  </View>
                )}
                keyExtractor={(item, index) => index.toString()}
              />
            )}
          </>
        )}
      </View>
      {error && <Text style={styles.error}>Error: {error}</Text>}
    </View>
  );
  
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'flex-start',
    backgroundColor: '#76A1D8',
    paddingHorizontal: 50,
    paddingTop: 40, // Ajuste para evitar que los datos se superpongan
  },
  title: {
    fontSize: 30,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  pickerContainer: {
    width: '100%',
    marginBottom: 20,
    borderWidth: 20,
    borderColor: '#fff',
    borderRadius: 5,
    backgroundColor: '#fff',
    alignItems: 'center', // Alinear el contenido al centro horizontalmente
  },
  picker: {
    height: 20, // Establecer una altura adecuada para el Picker
    width: '90%', // Reducir el ancho del Picker para que quede dentro del contenedor blanco
  },
  
  asistenciasContainer: {
    flex: 1,
    width: '100%',
    marginTop: 150, // Espacio agregado entre la selección de materias y la lista de asistencias
  },
  itemContainer: {
    marginBottom: 20,//asistencia cajita 
    backgroundColor: '#ccc',
    padding: 10,
    borderRadius: 5,
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
    elevation: 5,
  },
  asistencia: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 8,
  },
  fecha: {
    fontSize: 16,
  },
  grupo: {
    fontSize: 16,
    color: '#666',
  },
  error: {
    color: 'red',
    marginTop: 10,
  },
});

export default GrupoAlumno;
