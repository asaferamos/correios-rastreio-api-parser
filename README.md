
# Correios Rastreio API Parser
API construída a partir de parsing da página de rastreio dos Correios.

[![Deploy](https://img.shields.io/badge/demo-heroku-430098.svg)](https://correios-rastreio-api-parser.herokuapp.com/)


## Utilização
Adicione o código de rastreio na url:
`http://localhost/correios/RE999999999BR`

#### Retorno

    [
	    {
		    "date": "12/01/2013",
		    "hour": "18:35",
		    "location": "Goiânia - GO",
		    "label": "Objeto entregue ao destinatário"
	    },
	    {
		    "date": "12/12/2012",
		    "hour": "12:12",
		    "location": "Valparaíso - GO",
		    "label": "Objeto postado"
	    }

    ]
