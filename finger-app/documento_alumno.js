import * as DocumentPicker from 'expo-document-picker';
import React, { useState } from 'react';
import { Button, FlatList, StyleSheet, Text, TouchableOpacity, View } from 'react-native';

const DocumentPage = () => {
  const [documents, setDocuments] = useState([]);

  const uploadDocument = async () => {
    try {
      const result = await DocumentPicker.getDocumentAsync({
        type: 'application/pdf,text/plain',
        copyToCacheDirectory: false,
      });

      if (result.type === 'success') {
        const { name, uri } = result;
        console.log('Documento seleccionado:', name, uri);
        // Aquí deberías implementar la lógica para manejar el archivo seleccionado
        setDocuments([...documents, name]);
      } else {
        // El usuario canceló la selección
      }
    } catch (error) {
      console.error('Error al seleccionar el documento:', error);
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Documentos del Alumno</Text>
      <Button
        title="Subir Documento"
        onPress={uploadDocument}
        color="#007bff"
      />
      <FlatList
        data={documents}
        keyExtractor={(item, index) => index.toString()}
        renderItem={({ item }) => (
          <TouchableOpacity onPress={() => console.log('Documento seleccionado:', item)}>
            <View style={styles.documentItem}>
              <Text>{item}</Text>
            </View>
          </TouchableOpacity>
        )}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#ffffff',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  documentItem: {
    padding: 10,
    borderBottomWidth: 1,
    borderBottomColor: '#cccccc',
  },
});

export default DocumentPage;
