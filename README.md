# API Consulta - Perú
[![Travis-CI](https://img.shields.io/travis/giansalex/peru-consult-api.svg?label=build&branch=master&style=flat-square)](https://travis-ci.org/giansalex/peru-consult-api)  
API para consultar el DNI o RUC - Perú empleando [peru-consult](https://github.com/giansalex/peru-consult) package.

### Docker

Install from [Docker Hub](https://hub.docker.com/r/giansalex/peru-consult-api/)
```bash
docker pull giansalex/peru-consult-api
```

### DNI

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

