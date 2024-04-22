import React from 'react';
import { StyleSheet, Text, View } from 'react-native';

export default function SobreNosotros() {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Sobre Nosotros</Text>
      <View style={styles.descriptionContainer}>
        <Text style={styles.descriptionText}>
          Somos un equipo de desarrolladores dedicados a proporcionarte una herramienta que te permita obtener información sobre el alumno de manera fácil y rápida.
        </Text>
        <View style={styles.contactContainer}>
          <Text style={styles.contactText}>
            Contacto: fingertuto@gmail.com
          </Text>
        </View>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#FFFFFF',
    paddingHorizontal: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginTop: 20, // Ajuste para que el título esté más arriba
    textAlign: 'center',
    color: '#333333',
  },
  descriptionContainer: {
    backgroundColor: '#0F73F8', // Color de fondo del cuadro de descripción
    padding: 20, // Espaciado interno del cuadro de descripción
    borderRadius: 10, // Bordes redondeados del cuadro de descripción
    marginTop: 20, // Espaciado hacia arriba desde el título
  },
  descriptionText: {
    fontSize: 18,
    textAlign: 'center',
    color: '#FFFFFF', // Color de texto blanco dentro del cuadro
    marginBottom: 10, // Ajuste de espacio después del texto de descripción
  },
  contactContainer: {
    marginTop: 10, // Espaciado hacia abajo desde el texto de descripción
  },
  contactText: {
    fontSize: 16,
    textAlign: 'center',
    color: '#FFFFFF', // Color de texto blanco dentro del cuadro
  },
});