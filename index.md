# getUpdatesBot | Guida Beta
A simple way to create a Telegram Bot using getUpdates.

[![Dona](https://img.shields.io/badge/%F0%9F%92%99-Donate-blue.svg)](https://www.paypal.me/Neneone) [![Download](https://img.shields.io/badge/dynamic/json.svg?label=Download&uri=https%3A%2F%2Fenea.rhosting.network%2FgetUpdatesBot%2FcountDownloads%2F&query=total&colorB=brightgreen)](https://enea.rhosting.network/getUpdatesBot/download)

## FAQ
- Cos'è getUpdatesBot?
  - È un PHP Framwork per creare Telegram Bot usando le [Bot API](https://core.telegram.org/bots/api) ed il metodo getUpdates.
- Cos'ha di meglio degli altri frameworks?
  - Leggi le [features](#features).
- Come si installa?
  - Leggi l'[installazione](#installazione).
- Posso aiutare?
  - Sì, puoi creare una Pull Request.

## Requisiti

Per utilizzare getUpdatesBot è necessario un server (possibilmente VPS) con accesso SSH, PHP <= 7.1 ed alcune sue estensioni.

## Installazione

Per installare getUpdatesBot bisogna prima di tutto usare questo comando:

```
$ sudo apt-get -y install git zip screen curl python php7.1 php-mbstring php-xml php-gmp php-curl php-bcmath php-zip php-json && git clone https://github.com/Neneone/getUpdatesBot && cd getUpdatesBot && rm README.md && rm _config.yml
```

A questo punto aprire `api_token.php` e inserire il token del bot.

## Avviare il bot

Il bot si può avviare in due modi diversi: normalmente, oppure in background.
- Normalmente: lo script viene eseguito nella tua pagina del terminale e quando la chiudi si ferma.
- Background: lo script viene eseguito in una pagina del terminale che non si ferma quando si chiude la principale. Si può accedere ad essa con `screen -r`.

## Aggiornare getUpdatesBot

Per aggiornare getUpdatesBot è sufficiente usare

```
$ php start.php update
```

## Modificare la lingua

Il bot utilizza i file della lingua ce sono in un file come `trad_it.json` o `trad_en.json`. Si può impostare la lingua cambiando il parametro `language` nelle impostazioni. Se la lingua impostata non esiste (o non c'è un file scaricato che la contenga) viene utilizzata quella italiana o inglese. Se non c'è nessuna lingua installata viene automaticamente installata la lingua italiana o inglese.

## Features

- Il bot recupera tutti gli updates persi nel caso in cui fosse stato offline.
- Il bot può essere utilizzato in background.
- Il bot si può aggiornare in modo semplice e con un solo comando.
- Si può impostare la lingua.
