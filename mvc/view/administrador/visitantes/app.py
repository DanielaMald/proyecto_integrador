from flask import Flask, render_template, jsonify, request
import requests

app = Flask(__name__)


@app.route("/")
def inicio():
    return render_template('registros_visitante.html')
    
@app.route("/visitantes")
def crear():
    return render_template('formulario_visitantes.html')
@app.route("/buscar")
def buscar():
    return render_template('buscar.html')


    

    
        

if __name__ == '__main__':
    app.run(debug=True)