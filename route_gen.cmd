@echo off

REM Crea la estructura del proyecto
mkdir public
cd public
mkdir img
cd img
echo. > logo.png
cd ..
cd ..
mkdir src
cd src
mkdir routes
cd routes
echo. > index.js
echo. > generador_identificador.js
echo. > vista.js
echo. > vista_ip.js
echo. > login.js
cd ..
mkdir views
cd views
echo. > generador_identificador.ejs
echo. > vista.ejs
echo. > vista_ip.ejs
echo. > login.ejs
cd ..
echo. > environment_loader.js
echo. > setup_db.js
echo. > d.js
echo. > server.js
cd ..

REM Crea el archivo package.json
echo {
echo   "name": "HRPL",
echo   "version": "1.0.0",
echo   "description": "High-precision, real-time people locator via a link",
echo   "main": "server.js",
echo   "scripts": {
echo     "start": "node server.js"
echo   },
echo   "dependencies": {
echo     "express": "^4.17.1",
echo     "body-parser": "^1.19.0",
echo     "express-session": "^1.17.1",
echo     "ejs": "^3.1.6",
echo     "mysql2": "^2.2.5"
echo   }
echo } > package.json

echo.
echo Proyecto creado exitosamente en la carpeta "HRPL".
