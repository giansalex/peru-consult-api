# API Consulta - Perú
[![CircleCI](https://circleci.com/gh/giansalex/peru-consult-api.svg?style=svg)](https://circleci.com/gh/giansalex/peru-consult-api) [![Travis-CI](https://img.shields.io/travis/giansalex/peru-consult-api.svg?label=build&branch=master&style=flat-square)](https://travis-ci.org/giansalex/peru-consult-api) [![Docker Build Status](https://img.shields.io/docker/build/giansalex/peru-consult-api.svg?style=flat-square)](https://hub.docker.com/r/giansalex/peru-consult-api/builds/) [![Docker Pulls](https://img.shields.io/docker/pulls/giansalex/peru-consult-api.svg?style=flat-square)]() [![GitHub issues](https://img.shields.io/github/issues/giansalex/peru-consult-api.svg?style=flat-square)]()  
API para consultar el DNI o RUC - Perú, empleando [peru-consult](https://github.com/giansalex/peru-consult) package.

## Install

### Using Docker

Install from [Docker Hub](https://hub.docker.com/r/giansalex/peru-consult-api/)
```bash
docker pull giansalex/peru-consult-api
```

### As Windows Service

> Before uninstall previous installations
- Download [installer](https://github.com/giansalex/peru-consult-api/releases/latest).  
- Run setup as Administrator Level.    
- After install go to http://127.0.0.1:8099/

### From Source code

Clone the source code.
```
git clone https://github.com/giansalex/peru-consult-api.git
```

**Requirements**
- dom extension for Ruc class.
- gd, pdo_sqlite extension for Dni class.

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

## Examples
### GraphQL
Implementando soporte para [graphql](http://graphql.org/) utilizar el endpoint `/api/v1/graph`   

```
query { 
    person(dni: "48004836") {
    	dni
    	nombres
    },
    company(ruc: "20131312955") {
    	ruc
    	razonSocial
    }
}
```
Respuest:
```json
{
    "data": {
        "person": {
            "dni": "48004836",
            "nombres": "ROBERTO CARLOS"
        },
        "company": {
            "ruc": "20131312955",
            "razonSocial": "SUPERINTENDENCIA NACIONAL DE ADUANAS Y DE ADMINISTRACION TRIBUTARIA - SUNAT"
        }
    }
}
```

### DNI
Ejecutar usando Curl.
```bash
curl -H "Accept: application/json" http://localhost:8090/api/v1/dni/48004836
```

Respuesta:

```json
{
  "dni": "48004836",
  "nombres": "ROBERTO CARLOS",
  "apellidoPaterno": "SULCA",
  "apellidoMaterno": "BASILIO",
  "codVerifica": "4"
}
```

### RUC
Ejecutar usando Curl.
```bash
curl -H "Accept: application/json" http://localhost:8090/api/v1/ruc/20131312955
```

Respuesta:

```json
{
  "ruc": "20131312955",
  "razonSocial": "SUPERINTENDENCIA NACIONAL DE ADUANAS Y DE ADMINISTRACION TRIBUTARIA - SUNAT",
  "nombreComercial": "-",
  "telefonos": [
    "6343300",
    "999999999",
    "999999998"
  ],
  "tipo": "INSTITUCIONES PUBLICAS",
  "estado": "ACTIVO",
  "condicion": "HABIDO",
  "direccion": "AV. GARCILASO DE LA VEGA NRO. 1472 LIMA - LIMA - LIMA",
  "departamento":"LIMA",
  "provincia":"LIMA",
  "distrito":"LIMA",
  "fechaInscripcion": "04/05/1993",
  "sistEmsion": "MANUAL/COMPUTARIZADO",
  "sistContabilidad": "COMPUTARIZADO",
  "actExterior": "SIN ACTIVIDAD",
  "actEconomicas": [
    "75113 - ACTIV. ADMINIST. PUBLICA EN GENERAL"
  ],
  "cpPago": [
    "FACTURA",
    "BOLETA DE VENTA",
    "NOTA DE CREDITO",
    "NOTA DE DEBITO",
    "GUIA DE REMISION - REMITENTE",
    "COMPROBANTE DE RETENCION",
    "POLIZA DE ADJUDICACION POR REMATE DE BIENES"
  ],
  "sistElectronica": [
    "FACTURA PORTAL                      DESDE 07/08/2013",
    "BOLETA PORTAL                       DESDE 01/04/2016"
  ],
  "fechaEmisorFe": "07/08/2013",
  "cpeElectronico": [
    "FACTURA (desde 07/08/2013)",
    "BOLETA (desde 01/04/2016)"
  ],
  "fechaPle": "01/01/2013",
  "padrones": [
    "Incorporado al Régimen de Agentes de Retención de IGV (R.S.037-2002) a partir del 01/06/2002"
  ]
}
```


### GraphiQL Tool
Para mejorar aún más nuestra experiencia en pruebas, sugerimos comenzar a utilizar el cliente GraphiQL.
Es un Explorador de esquema GraphQL que puede descargar desde Chrome Store. Utilizar el endpoint `/api/v1/graph`, el editor tiene una función de autocompletar y contiene toda la información sobre el esquema actual en el lado derecho en la barra lateral de Documentos:
![GraphiQL Interface](https://raw.githubusercontent.com/giansalex/peru-consult-api/master/docs/screenshot-graph.png)
