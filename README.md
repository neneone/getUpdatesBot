# getUpdatesBot
A simple way to create a Telegram Bot using getUpdates.

[![Dona](https://img.shields.io/badge/%F0%9F%92%99-Donate-blue.svg)](https://www.paypal.me/Neneone)

## Iniziare

### Requisiti

Per poter utilizzare getUpdatesBot è necessario un VPS con accesso SSH, con installato PHP 7.2 e le sue estensioni e screen.
Per installare screen è sufficiente utilizzare:
```
sudo apt-get update
sudo apt-get install screen
```

### Installazione

Per installare getUpdatesBot bisogna caricare i file nel root del VPS e installare i pacchetti richiesti.

### Funzionamento teorico del bot
- Il bot tramite un ciclo (while) continuamente verifica se ci sono nuovi updates.
- Quando prende un update attiva \_commands.php e aggiorna le variabili di \_variables.php.
- \_commands.php utilizzando le funzioni di \_functions.php interagisce con le [BotAPI](https://core.telegram.org/bots/api) e fa inviare un messaggio al bot.

## Avvio e spegnimento del bot

Un bot creato con getUpdatesBot può avviarsi in due modi: normalmente o in background (utilizzando screen).

### Avviare il bot normalmente

Per avviare il bot normalmente basterà accedere al VPS tramite SSH e scrivere:
```
cd getUpdatesBot
php start.php
```
Dove getUpdatesBot sta per il nome della cartella in cui avete messo il bot.

### Avviare il bot in background

Per avviare il bot in background bisognerà invece scrivere:
```
cd getUpdatesBot
php start.php background
```

### Spegnere il bot

Per spegnere il bot avviato normalmente basterà digitare CTRL + C o chiudere il client SSH

Per spegnere il bot avviato in background bisognerà scrivere
```
screen -r
```
e successivamente CTRL + C.

## Aggiornare il bot

Per aggiornare il bot è sufficiente digitare
```
php start.php update
```
e attendere qualche secondo.

## Features

Features del bot:
- Il bot recupera tutti gli Updates persi quando torna online nel caso in cui fosse andato offline.
- Può funzionare anche in background per essere sempre online.
- Il bot si può aggiornare direttamente dal Terminale.
