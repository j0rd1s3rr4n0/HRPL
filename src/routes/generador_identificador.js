const express = require('express');
const router = express.Router();
const db = require('../../db');

router.get('/', (req, res) => {
  // Manejar la solicitud GET para la página generador_identificador
  res.render('generador_identificador', { status: req.query.status });
});

// Agrega tu lógica de ruta POST aquí

module.exports = router;
