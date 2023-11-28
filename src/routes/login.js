const express = require('express');
const router = express.Router();
const db = require('../../db');

router.get('/', (req, res) => {
  // Manejar la solicitud GET para la página de inicio de sesión
  res.render('login');
});

// Agrega tu lógica de ruta POST aquí

module.exports = router;
