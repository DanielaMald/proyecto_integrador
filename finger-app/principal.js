import React, { useState } from 'react';
import { Image, Modal, SafeAreaView, StyleSheet, Text, TextInput, TouchableOpacity, View } from 'react-native';

export default function LoginScreen({ navigation }) {
  const [correo, setCorreo] = useState('');
  const [matricula, setMatricula] = useState('');
  const [showError, setShowError] = useState(false);
  const [modalVisible, setModalVisible] = useState(false);

  const toggleModal = () => {
    setModalVisible(!modalVisible);
  };

  const login = () => {
    fetch('https://9zbklm0q-3000.usw3.devtunnels.ms/principal', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ correo: correo, matricula: matricula }),
    })
    .then(response => {
      if (response.ok) {
        setShowError(false);
        navigation.navigate('StudentProfilePage');
      } else {
        setShowError(true);
      }
    })
    .catch(error => {
      console.error('Error al iniciar sesión:', error);
      setShowError(true);
    });
  };

  return (
    <SafeAreaView style={styles.container}>
      <Text style={styles.heading}>Inicio de sesión</Text>
      <View style={styles.imageContainer}>
        <Image source={require('./assets/sesion.png')} style={styles.image} />
      </View>
      <View style={styles.form}>
        <View style={styles.inputContainer}>
          <TextInput
            style={styles.input}
            placeholder="Correo electrónico"
            keyboardType="email-address"
            autoCapitalize="none"
            autoCorrect={false}
            value={correo}
            onChangeText={setCorreo}
          />
        </View>
        <View style={styles.inputContainer}>
          <TextInput
            style={styles.input}
            placeholder="Contraseña"
            secureTextEntry={true}
            autoCapitalize="none"
            autoCorrect={false}
            value={matricula}
            onChangeText={setMatricula}
          />
        </View>
        <TouchableOpacity style={styles.loginButton} onPress={login}>
          <Text style={styles.buttonText}>Iniciar Sesión</Text>
        </TouchableOpacity>
        <Text style={styles.agreement}>
          {' '}
          <Text style={styles.link} onPress={toggleModal}>
            
          </Text>
          .
        </Text>
      </View>
      {showError && <Text style={styles.errorText}>Usuario o contraseña incorrectos</Text>}
      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisible}
        onRequestClose={() => {
          setModalVisible(!modalVisible);
        }}
      >
        <View style={styles.modalContainer}>
          <View style={styles.modalContent}>
            <Text style={styles.modalText}>Términos y Condiciones de Uso de TutoFinger</Text>
            <Text style={styles.modalText}>
              Bienvenido a TutoFinger. Estos términos y condiciones de uso (en adelante, los "Términos") rigen el acceso y uso
              de la aplicación TutoFinger (en adelante, la "Aplicación"), desarrollada por un equipo de desarrolladores. Al
              utilizar la Aplicación, aceptas estos Términos en su totalidad. Si no estás de acuerdo con alguno de los términos,
              por favor, no utilices la Aplicación.
            </Text>
            <Text style={styles.modalText}>1. Uso de la Aplicación</Text>
            <Text style={styles.modalText}>
              - La Aplicación TutoFinger tiene como finalidad principal facilitar a los tutores el acceso y gestión de la
              información del alumno de manera rápida, segura y sencilla.
            </Text>
            <Text style={styles.modalText}>
              - Al utilizar la Aplicación, el usuario acepta proporcionar información precisa y actualizada sobre el alumno y
              garantiza que tiene el consentimiento necesario para acceder y utilizar dicha información.
            </Text>
            <Text style={styles.modalText}>2. Funcionalidades de la Aplicación</Text>
            <Text style={styles.modalText}>
              - Fingertuto permite a los tutores:
              {'\n'}
              - Visualizar la información del alumno, incluyendo asistencias, materias, matrícula y nombre del alumno.
              {'\n'}
              - Acceder a un chat para comunicarse con el profesor de una materia específica para tratar temas escolares o
              referentes al alumno.
            </Text>
            <Text style={styles.modalText}>3. Responsabilidades del Usuario</Text>
            <Text style={styles.modalText}>
              - El usuario se compromete a utilizar la Aplicación de manera responsable y respetando la privacidad y derechos de
              terceros.
              {'\n'}
              - El usuario es responsable de mantener la confidencialidad de su cuenta y contraseña, y de todas las actividades
              que ocurran bajo su cuenta.
            </Text>
            <Text style={styles.modalText}>4. Privacidad y Protección de Datos</Text>
            <Text style={styles.modalText}>
              - TutoFinger se compromete a proteger la privacidad de los usuarios y la seguridad de sus datos personales,
              cumpliendo con las leyes de protección de datos aplicables.
              {'\n'}
              - La información del alumno recopilada a través de la Aplicación será utilizada únicamente con fines educativos y
              de gestión escolar.
            </Text>
            <Text style={styles.modalText}>5. Modificaciones y Actualizaciones</Text>
            <Text style={styles.modalText}>
              - TutoFinger se reserva el derecho de realizar modificaciones en estos Términos en cualquier momento. Las
              modificaciones entrarán en vigor tras su publicación en la Aplicación.
            </Text>
            <TouchableOpacity onPress={toggleModal}>
              <Text style={styles.closeButton}>Cerrar</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    backgroundColor: '#F8F9FD',
    paddingHorizontal: 20,
  },
  heading: {
    textAlign: 'center',
    fontWeight: 'bold',
    fontSize: 30,
    color: '#0F73F8',
    marginBottom: 20,
  },
  imageContainer: {
    alignItems: 'center',
    marginBottom: 20,
  },
  image: {
    width: 150,
    height: 150,
    borderRadius: 75,
    resizeMode: 'cover',
  },
  form: {
    width: '100%',
    alignItems: 'center',
  },
  inputContainer: {
    marginBottom: 15,
    width: '100%',
    borderRadius: 20,
    paddingHorizontal: 10,
    backgroundColor: '#FFFFFF',
    shadowColor: '#cff0ff',
    shadowOffset: { width: 0, height: 10 },
    shadowOpacity: 0.5,
    shadowRadius: 10,
    elevation: 5,
  },
  input: {
    width: '100%',
    paddingVertical: 15,
    paddingHorizontal: 20,
    fontSize: 16,
  },
  loginButton: {
    width: '100%',
    backgroundColor: '#0F73F8',
    borderRadius: 20,
    paddingVertical: 15,
    justifyContent: 'center',
    alignItems: 'center',
    shadowColor: '#85BDD7',
    shadowOffset: { width: 0, height: 10 },
    shadowOpacity: 0.5,
    shadowRadius: 10,
    elevation: 5,
    marginTop: 10,
  },
  buttonText: {
    color: '#FFFFFF',
    fontWeight: 'bold',
    fontSize: 18,
  },
  agreement: {
    textAlign: 'center',
    marginTop: 15,
  },
  link: {
    color: '#0099ff',
    textDecorationLine: 'underline',
  },
  errorText: {
    color: 'red',
    marginBottom: 10,
  },
  modalContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
  },
  modalContent: {
    backgroundColor: '#FFFFFF',
    borderRadius: 20,
    padding: 20,
    alignItems: 'center',
  },
  modalText: {
    marginBottom: 10,
  },
  closeButton: {
    color: '#0099ff',
    textDecorationLine: 'underline',
  },
});
