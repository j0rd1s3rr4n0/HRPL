const express = require('express');
const router = express.Router();

router.get('/', (req, res) => {
  // Manejar la solicitud GET para la página principal
  res.render('index');
});

module.exports = router;
