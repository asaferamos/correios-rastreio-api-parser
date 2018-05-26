
# Correios Rastreio API Parser
API construída a partir de parsing da página de rastreio dos Correios.

[![Deploy](https://img.shields.io/badge/demo-heroku-430098.svg)](https://correios-rastreio-api-parser.herokuapp.com/)


## Utilização

```
$Correios = new \Baru\Correios\RastreioParser();
$Correios->setCode('RE999999999BR');

//Último evento
$Evento = $Correios->getEventLast();

//Lista todos eventos
$Eventos = $Correios->getEventsList();
```

#### Evento
Label
`$evento->getLabel();`
> _Objeto postado_
---
Location
`$evento->getLocation();`
> _Goiânia / GO_
---
Date
`$evento->getDate();`
> _12/12/2012_
---
Hour
`$evento->getHour();`
> _12:12_
---
Description
`$evento->getDescription();`
> _de Unidade de Distribuição em SUMARE / SP para Agência dos Correios em SUMARE / SP_
