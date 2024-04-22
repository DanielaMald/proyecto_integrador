import React, { useEffect, useState } from 'react';
import { FlatList, StyleSheet, Text, View } from 'react-native';

const AsistenciaAlumno = ({ correo, matricula }) => {
  const [materias, setMaterias] = useState([]);
  const [asistenciasPorMateria, setAsistenciasPorMateria] = useState({});
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    obtenerMaterias();
  }, []);

  const obtenerMaterias = () => {
    setLoading(true);
    // Aquí realiza la petición para obtener las materias asignadas al alumno
    fetch('URL_PARA_OBTENER_MATERIAS', {
      method: 'GET',
      // Añade cualquier configuración de cabecera necesaria, como tokens de autenticación
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Error al obtener las materias asignadas. Código de estado: ' + response.status);
        }
        return response.json();
      })
      .then(data => {
        setMaterias(data); // Guarda las materias obtenidas del servidor
        obtenerAsistenciasPorMateria(data); // Llama a la función para obtener las asistencias por materia
        setLoading(false);
      })
      .catch(error => {
        console.error('Error al obtener las materias asignadas:', error);
        setError('Error al obtener las materias asignadas. Por favor, inténtalo de nuevo más tarde.');
        setLoading(false);
      });
  };

  const obtenerAsistenciasPorMateria = (materias) => {
    // Itera sobre cada materia y realiza una petición para obtener las asistencias por materia
    materias.forEach(materia => {
      // Aquí realiza la petición para obtener las asistencias por materia
      fetch(`URL_PARA_OBTENER_ASISTENCIAS_POR_MATERIA/${materia.id_asignatura}`, {
        method: 'GET',
        // Añade cualquier configuración de cabecera necesaria, como tokens de autenticación
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Error al obtener las asistencias por materia. Código de estado: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
          // Guarda las asistencias por materia en un objeto con la materia como clave
          setAsistenciasPorMateria(prevState => ({
            ...prevState,
            [materia.id_asignatura]: data,
          }));
        })
        .catch(error => {
          console.error('Error al obtener las asistencias por materia:', error);
          setError('Error al obtener las asistencias por materia. Por favor, inténtalo de nuevo más tarde.');
        });
    });
  };

  // Renderiza los elementos de la lista de asistencias por materia
  const renderAsistenciaItem = ({ item }) => {
    return (
      <View style={styles.tableRow}>
        <Text style={styles.cell}>{item.fecha}</Text>
        <Text style={styles.cell}>{item.asistencia === 1 ? 'ASISTIO' : 'FALTO'}</Text>
      </View>
    );
  };

  // Renderiza la lista de asistencias por materia
  const renderAsistenciasPorMateria = () => {
    return materias.map(materia => (
      <View key={materia.id_asignatura}>
        <Text style={styles.materiaTitle}>{materia.nombre}</Text>
        {asistenciasPorMateria[materia.id_asignatura] ? (
          <FlatList
            data={asistenciasPorMateria[materia.id_asignatura]}
            renderItem={renderAsistenciaItem}
            keyExtractor={(item, index) => index.toString()}
          />
        ) : (
          <Text style={styles.loadingText}>Cargando asistencias...</Text>
        )}
      </View>
    ));
  };

  return (
    <View style={styles.container}>
      {loading ? (
        <Text style={styles.loadingText}>Cargando materias...</Text>
      ) : error ? (
        <Text style={styles.error}>Error: {error}</Text>
      ) : (
        renderAsistenciasPorMateria()
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    paddingHorizontal: 20,
    paddingTop: 20,
    backgroundColor: '#fff',
  },
  tableRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
    paddingVertical: 10,
  },
  cell: {
    flex: 1,
    textAlign: 'center',
  },
  materiaTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    marginTop: 20,
    marginBottom: 10,
  },
  loadingText: {
    marginTop: 10,
    textAlign: 'center',
  },
  error: {
    color: 'red',
    marginTop: 10,
    textAlign: 'center',
  },
});

export default AsistenciaAlumno;
