import { Ionicons } from '@expo/vector-icons';
import React, { useEffect, useState } from 'react';
import { SafeAreaView, StyleSheet, Text, TouchableOpacity, View } from 'react-native';

const StudentProfilePage = ({ navigation }) => {
  const [profileData, setProfileData] = useState(null);

  useEffect(() => {
    fetch('https://9zbklm0q-3000.usw3.devtunnels.ms/perfil', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
      credentials: 'include',
    })
      .then(response => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error('Error al obtener el perfil del alumno');
        }
      })
      .then(data => {
        setProfileData(data);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }, []);

  const handleVerGrupo = () => {
    navigation.navigate('GrupoAlumno');
  };

  const handleComentarios = () => {
    navigation.navigate('ComentariosPage');
  };

  const handleCerrarSesion = () => {
    navigation.navigate('Home');
  };

  return (
    <SafeAreaView style={styles.safeAreaView}>
      <View style={styles.container}>
        <View style={styles.buttonContainer}>
          <TouchableOpacity style={styles.iconButton} onPress={handleVerGrupo}>
            <Ionicons name="people-outline" size={24} color="white" />
            <Text style={styles.buttonText}>Ver Grupo</Text>
          </TouchableOpacity>
          <TouchableOpacity style={styles.iconButton} onPress={handleComentarios}>
            <Ionicons name="chatbubbles-outline" size={24} color="white" />
            <Text style={styles.buttonText}>Comentarios</Text>
          </TouchableOpacity>
          <TouchableOpacity style={styles.iconButton} onPress={handleCerrarSesion}>
            <Ionicons name="exit-outline" size={24} color="white" />
            <Text style={styles.buttonText}>Cerrar Sesión</Text>
          </TouchableOpacity>
        </View>
        <View style={styles.profileInfo}>
          <Text style={styles.title}>Perfil del Alumno</Text>
          {profileData && (
            <>
              <Text style={styles.greeting}>¡Bienvenid@ {profileData.nombre}!</Text>
              <Text style={styles.infoText}>Nombre: {profileData.nombre}</Text>
              <Text style={styles.infoText}>Matrícula: {profileData.matricula}</Text>
            </>
          )}
        </View>
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeAreaView: {
    flex: 1,
    backgroundColor: '#ffffff',
  },
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#ffffff',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    textAlign: 'center',
  },
  profileInfo: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  greeting: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  infoText: {
    fontSize: 18,
    marginBottom: 10,
  },
  buttonContainer: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    paddingHorizontal: 20,
    paddingTop: 20,
  },
  iconButton: {
    flexDirection: 'row',
    backgroundColor: '#007bff',
    paddingVertical: 15,
    paddingHorizontal: 20,
    marginBottom: 10,
    borderRadius: 8,
    alignItems: 'center',
  },
  buttonText: {
    color: '#ffffff',
    fontSize: 18,
    fontWeight: 'bold',
    marginLeft: 10,
  },
});

export default StudentProfilePage;
