import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import React, { useEffect, useState } from 'react';
import { Image, StyleSheet, Text, TouchableOpacity, View } from 'react-native';
import ComentariosPage from './ComentariosPage.js';

import DocumentPage from './documento_alumno';
import EticaScreen from './etica.js';
import GrupoAlumno from './grupo_alumno';
import HistoriaScreen from './historia.js';
import InglesScreen from './ingles.js';
import MatematicasScreen from './matematicas.js';
import StudentProfilePage from './perfil_alumno';
import PrincipalScreen from './principal';


const Stack = createNativeStackNavigator();

function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home" screenOptions={{ headerShown: false }}>
        <Stack.Screen name="Principal" component={PrincipalScreen} />
        <Stack.Screen name="Home" component={HomeScreen} />
        <Stack.Screen name="StudentProfilePage" component={StudentProfilePage} options={{ title: 'Perfil del Alumno' }} />
        <Stack.Screen name="GrupoAlumno" component={GrupoAlumno} />
        <Stack.Screen name="DocumentPage" component={DocumentPage} />
        <Stack.Screen name="ComentariosPage" component={ComentariosPage} /> 
        <Stack.Screen name="Matematicas" component={MatematicasScreen} />
        <Stack.Screen name="Ingles" component={InglesScreen} />
        <Stack.Screen name="Etica" component={EticaScreen} />
        <Stack.Screen name="Historia" component={HistoriaScreen} />
      
        
      </Stack.Navigator>
    </NavigationContainer>
  );
}

function HomeScreen({ navigation }) {
  const [showMenu, setShowMenu] = useState(false);
  const [greeting, setGreeting] = useState('');

  useEffect(() => {
    const date = new Date();
    const hour = date.getHours();

    let greetingMsg = '';

    if (hour >= 5 && hour < 12) {
      greetingMsg = '¡Buenos días';
    } else if (hour >= 12 && hour < 18) {
      greetingMsg = '¡Buenas tardes';
    } else {
      greetingMsg = '¡Buenas noches';
    }

    setGreeting(`${greetingMsg}, bienvenid@ a la app segura para tutores!`);
  }, []);

  return (
    <View style={styles.container}>
      <TouchableOpacity style={styles.menuButton} onPress={() => setShowMenu(!showMenu)}>
        <View style={styles.circle}>
          <Text style={styles.menuButtonText}>☰</Text>
        </View>
      </TouchableOpacity>
      
      
      
      <Image source={require('./assets/definitivo_creo.gif')} style={styles.image} />
      <TouchableOpacity onPress={() => navigation.navigate('Principal')} style={styles.button}>
        <Text style={styles.buttonText}>Acceso</Text>
      </TouchableOpacity>

      <View style={styles.textContainer}>
        <Text style={styles.subtitle}>{greeting}</Text>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#FFFFFF', // Fondo azul claro
  },
  menuButton: {
    position: 'absolute',
    top: 0, // Ajusta la posición del botón de menú
    left: 20,
    zIndex: 1,
  },
  circle: {
    width: 0,
    height: 0,
    borderRadius: 20,
    backgroundColor: '#0F73F8', // Azul
    justifyContent: 'center',
    alignItems: 'center',
  },
  menuButtonText: {
    fontSize: 24,
    color: '#fff', // Blanco
  },
  image: {
    width: 350,
    height: 350,
    marginBottom: 20,
  },
  button: {
    backgroundColor: '#007bff',
    padding: 10,
    borderRadius: 5,
  },
  buttonText: {
    color: '#fff',
    fontSize: 18,
  },
  textContainer: {
    backgroundColor: '#fff',
    padding: 20,
    borderRadius: 10,
    shadowColor: '#000',
    shadowOffset: {
      width: 0,
      height: 3,
    },
    shadowOpacity: 0.3,
    shadowRadius: 5,
    elevation: 5,
    width: '80%', // Ancho ajustado
    maxWidth: 300, // Máximo ancho
    marginBottom: 20, // Separación del botón
  },
  subtitle: {
    fontSize: 18,
    color: '#2C3E50', // Azul oscuro
    textAlign: 'center',
    marginBottom: 20,
    fontWeight: 'bold',
  },
});

export default App;