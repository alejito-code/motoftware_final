from flask import Flask, render_template, request, redirect, url_for, send_file, flash
from reportlab.pdfgen import canvas
from reportlab.lib.pagesizes import letter
from reportlab.lib.utils import simpleSplit
from io import BytesIO
import mysql.connector

app = Flask(__name__)
app.secret_key = 'pandevono'

# Establecer la conexión con la base de datos MySQL
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="", 
    database="motoft"
)

# verificamos si la conexión es exitosa
if conn.is_connected():
    print("Conexión exitosa con la base de datos MySQL.")
else:
    print("Hubo un problema al conectar con la base de datos MySQL.")

# almacenamos las preguntas y las opciones en una lista

preguntas = [
    {"pregunta": "¿Hace cuanto no le hace un mantenimiento Preventivo a su moto?", "opciones": ["Hace 6 meses", "Desde que la compre", "Hace dos años", "Hace tres meses"]},
    {"pregunta": "¿Cada cuanto le cambia el Aceite a su moto?", "opciones": ["Cada 3.000 Km", "Cada 2.8000km", "Cada 3.2000km "]},
    {"pregunta": "¿Cada cuanto le cambia la batería a su Moto?", "opciones": ["Cada año", "Cada dos años y medio", "Cada dos años", "Cada tres años"]},
    {"pregunta": "¿Cuándo fue la ultima vez que le hizo un cambio de Disco de freno  a su moto?", "opciones": ["Hace 8 meses", "Hace 12 meses", "Hace 24 meses"]},
    {"pregunta": "¿Ha tenido alguna colisión o accidente reciente con su motocicleta?", "opciones": ["Sí", "No"]},
    {"pregunta": "¿Cuando enciende el swuiche de su moto a esta le enciende el tablero?", "opciones": ["Si", "No"]},
    {"pregunta": "¿Si la moto esta encendida siente algún sonido raro en el motor?", "opciones": ["Si", "No"]},
    {"pregunta": "¿Cada cuanto le cambia las pastas del Closth a su moto?", "opciones": ["Cada cuatro meses", "Cada cinco meses", "Cada seis meses", "Mas tiempo"]},
    {"pregunta": "¿La moto es de concesionario o de segunda?", "opciones": ["Concesionario", "Segunda"]},
    {"pregunta": "¿Qué tando hace uso de su moto?", "opciones": ["Diario", "Frecuentemente", "Ocasionalmente", "Muy poco uso"]}
]

respuestas = []
pregunta_actual = 0

@app.route('/', methods=['GET', 'POST']) #formulario muestra las preguntas y sus opciones de respuesta y guarda los resultados 
def formulario():
    global pregunta_actual

    if request.method == 'POST':
        respuesta = request.form.get('respuesta')
        respuestas.append((preguntas[pregunta_actual]["pregunta"], respuesta))
        pregunta_actual += 1

        if pregunta_actual == len(preguntas) - 1: 
            return render_template('formulario_2.html', pregunta=preguntas[pregunta_actual], pregunta_actual=pregunta_actual)

        pregunta = preguntas[pregunta_actual]
        return render_template('formulario.html', pregunta=pregunta, pregunta_actual=pregunta_actual)

    pregunta_actual = 0
    respuestas.clear()
    pregunta = preguntas[pregunta_actual]
    return render_template('formulario.html', pregunta=pregunta, pregunta_actual=pregunta_actual)

@app.route('/resultado', methods=['GET', 'POST']) #muestra las preguntas junto con los resultados
def resultado():
    diagnostico = []

    if request.method == 'POST':
        try:
            guardar_pdf()
            flash('Respuestas enviadas al taller. Descargue el contenido si desea.', 'success')

        except Exception as e:
            flash(f'Error al guardar las respuestas: {e}', 'danger')

        respuestas_diagnostico = { #parte de diagnostico aun no funcional
            0: {"Hace 6 meses": "No hace mucho que la has llevado al taller eso está bien",
                "Desde que la compre": "Hace mucho tiempo que no llevas al taller, tal vez el fallo que se está presentando en este momento es porque no la has llevado a tiempo",
                "Hace dos años": "Hace mucho tiempo que no llevas al taller, tal vez el fallo que se está presentando en este momento es porque no la has llevado a tiempo",
                "Hace tres meses": "No hace mucho que la has llevado al taller eso está bien"},
            4: {"Si": "Recientemente tuviste un choque, esto también pudo haber influido en el daño que presentas ahora, y al no llevarla a un taller desde hace tanto tiempo deberías ir a revisarla",
                "No": "Me alegro que no hayas tenido accidentes recientes"},
            8: {"Concesionario": "Tu moto no debería estar presentando fallas ya que la compraste hace poco. Lo mejor es que te contactes con el concesionario y ellos se hagan responsables. Si la llevas a un taller y le meten mano, el concesionario podría decir que es por esto y no te validarían la garantía",
                "Segunda": "Deberías llevarla al taller lo más pronto posible ya que tu moto es de segunda debiste haber hecho un análisis detallado de esta para no tener estas fallas que presentas ahora. Llévala a un taller"}
        }

        for pregunta_id, respuesta in respuestas:
            if pregunta_id in respuestas_diagnostico:
                if respuesta in respuestas_diagnostico[pregunta_id]:
                    diagnostico.append(respuestas_diagnostico[pregunta_id][respuesta])

        return render_template('resultado.html', respuestas=respuestas, diagnostico=diagnostico)

    return render_template('resultado.html', respuestas=respuestas, diagnostico=diagnostico)

@app.route('/formulario-2', methods=['POST'])#formualrio almaecena la ultima pregunta y se ocupa de pasar de los formularios a resultado
def formulario_2():
    global pregunta_actual

    respuesta = request.form.get('respuesta')
    respuestas.append((preguntas[pregunta_actual]["pregunta"], respuesta))

    return redirect(url_for('resultado'))

@app.route('/download', methods=['GET'])
def download_pdf():
    response = generate_pdf()
    return response

def generate_pdf(): #generamos el pdf y le damos estilos con los estilos predeterminado que trae la libreria
    pdf_buffer = BytesIO()

    c = canvas.Canvas(pdf_buffer, pagesize=letter)
    c.setLineWidth(0.5)
    c.setFont('Helvetica', 12)

    c.drawCentredString(300, 750, "Respuestas Recopiladas:")
    y_position = 720
    line_height = 14

    for pregunta, respuesta in respuestas:
        pregunta_lines = simpleSplit(pregunta, 'Helvetica', 12, 400)
        for line in pregunta_lines:
            c.drawString(100, y_position, line)
            y_position -= line_height

        respuesta_lines = simpleSplit(respuesta, 'Helvetica', 12, 400)
        for line in respuesta_lines:
            c.drawString(100, y_position, line)
            y_position -= line_height

        c.line(100, y_position, 500, y_position)
        y_position -= line_height
        if y_position < 50:
            c.showPage()
            c.setFont('Helvetica', 12)
            y_position = 720

    c.save()

    pdf_buffer.seek(0)

    return send_file(pdf_buffer, as_attachment=True, download_name='respuestas.pdf')

def guardar_pdf():
    pdf_buffer = BytesIO()
    generate_pdf(pdf_buffer)

    # Inserción de datos
    cursor = conn.cursor()
    try:
        cursor.execute('''
            INSERT INTO diagnosticos (archivo_pdf, id_usuario)
            VALUES (%s, %s)
        ''', (pdf_buffer.getvalue(), 1))  # ID de usuario asumido como 1
        conn.commit()
        flash('PDF guardado correctamente en la base de datos.', 'success')
    except Exception as e:
        conn.rollback()
        flash(f'Error al guardar el PDF en la base de datos: {e}', 'danger')
    finally:
        cursor.close()

if __name__ == '__main__':
    app.run(debug=True)