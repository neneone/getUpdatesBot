# getUpdatesBot
A simple way to create a Telegram Bot using getUpdates.

[![Dona](https://img.shields.io/badge/%F0%9F%92%99-Donate-blue.svg)](https://www.paypal.me/Neneone)

## Iniziare

### Requisiti

Per poter utilizzare getUpdatesBot è necessario un VPS con accesso SSH, con installato PHP 7.2 e le sue estensioni e screen.
Se installi getUpdatesBot tramite l'installazione automatica ([qui](#installazione)) si installerà anch'esso, altrimenti usa:
```
$ sudo apt-get update
$ sudo apt-get install screen
```

### Installazione

Per l'installazione automatica è sufficiente usare:
```
$ curl https://neneone.github.io/getUpdatesBot_BetaInstaller.sh | sudo bash
```

Per installare getUpdatesBot manualmente bisogna caricare i file nel root del VPS e installare i pacchetti richiesti.

### Funzionamento teorico del bot
- Il bot tramite un ciclo (while) continuamente verifica se ci sono nuovi updates.
- Quando prende un update attiva `_commands.php` e aggiorna le variabili di `_variables.php`.
- `_commands.php` utilizzando le funzioni di `_functions.php` interagisce con le [BotAPI](https://core.telegram.org/bots/api) e fa inviare un messaggio al bot.

## Avvio e spegnimento del bot

Un bot creato con getUpdatesBot può avviarsi in due modi: normalmente o in background (utilizzando screen).

### Avviare il bot normalmente

Per avviare il bot normalmente basterà accedere al VPS tramite SSH e scrivere:
```
$ cd getUpdatesBot
$ php start.php
```
Dove getUpdatesBot sta per il nome della cartella in cui avete messo il bot.

### Avviare il bot in background

Per avviare il bot in background bisognerà invece scrivere:
```
$ cd getUpdatesBot
$ php start.php background
```

### Spegnere il bot

Per spegnere il bot avviato normalmente basterà digitare CTRL + C o chiudere il client SSH

Per spegnere il bot avviato in background bisognerà scrivere
```
$ screen -r
```
e successivamente CTRL + C.

## Aggiornare il bot

Se il bot è stato installato con l'installazione automatica ([qui](#installazione)), è sufficiente usare
```
$ php start.php update
```
e attendere qualche secondo. Altrimenti andrà fatta manualmente.

## Modificare la lingua

Per modificare la lingua bisogna andare in `settings.php` e modificare il valore "language." Nel caso in cui la lingua non sia stata scaricata e se non è "it" o "en" (due lingue di default), viene utilizzata la lingua inglese. Se la lingua è "it" o "en" e manca il file viene automaticamente scaricata ed utilizzata.

## Features

Features del bot:
- Il bot recupera tutti gli Updates persi quando torna online nel caso in cui fosse andato offline.
- Può funzionare anche in background per essere sempre online.
- Il bot si può aggiornare direttamente dal Terminale.
- Lingua impostabile.
