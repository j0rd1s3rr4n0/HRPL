const express = require('express');
const bodyParser = require('body-parser');
const session = require('express-session');
const app = express();
const port = 3000; // Puedes cambiar el puerto

app.use(bodyParser.urlencoded({ extended: true }));
app.use(session({ secret: 'your_secret_key', resave: true, saveUninitialized: true }));

// Archivos estáticos
app.use(express.static('public'));

// Configurar rutas
const indexRoute = require('./src/routes/index');
const generadorIdentificadorRoute = require('./src/routes/generador_identificador');
const vistaRoute = require('./src/routes/vista');
const vistaIpRoute = require('./src/routes/vista_ip');
const loginRoute = require('./src/routes/login');

app.use('/', indexRoute);
app.use('/generador_identificador', generadorIdentificadorRoute);
app.use('/vista', vistaRoute);
app.use('/vista_ip', vistaIpRoute);
app.use('/login', loginRoute);

app.listen(port, () => {
  console.log(`Servidor en ejecución en http://localhost:${port}`);
});
