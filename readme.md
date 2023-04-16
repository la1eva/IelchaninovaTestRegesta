# Sistema di consultazione della disponibilità dei prodotti di un negozio

## Contenuti
1. [Introduzione](#introduzione)
2. [Istruzioni d'uso](#istruzioni-duso)
3. [Tecnologie](#tecnologie)
4. [Gestione dei dati](#gestione-dei-dati)
5. [Elaborazione dei dati](#elaborazione-dei-dati)



## Introduzione
Questo progetto permette ad un utente di consultare la disponibilità di un ipotetico negozio di un certo prodotto ricercandolo per modello e inserendo la quantità desiderata. L'utente può decidere se preferire la consegna veloce o il prezzo più basso. E' prevista la modalità di consultazione sia per un eventuale pre-ordine sia nell'immediato. Si tiene conto degli sconti e offerte a seconda della quantità, periodo di acquisto o un totale della spesa. Il sistema fornisce tutte le occasioni dei vari fornitori, evidenziando la migliore.



## Istruzioni d'uso

Si inserisca il prodotto ricercato con il suo nome comune. Per esempio: *radio*  
Si inserisca il modello del prodotto. Per esempio *BRAVIA*  
Questi due inserimenti non sono case sensitive.  
Si inserisca la quantità. Deve essere un numero naturale positivo maggiore di uno, nel caso contrario si richiederà di reinserire la quantità. Se si tratta invece di un valore decimale, verrà arrotondato per difetto, quindi: se si inserisce *7.1*, la ricerca verrà fatta su *7*; se si inserisce un *0.5* si richiederà il reinserimento.  
Questi tre campi sono obbligatori e se lasciati vuoti, la ricerca non verrà eseguita e il sistema chiederà il loro inserimento all'utente.  
Si inserisca il periodo per cui si desidera avere il prodotto. Se si lascia il campo vuoto o con una data inadeguate, come per esempio un periodo già passato, il sistema aggiusterà la data con il giorno della ricerca fornendo così la disponibilità immediata.   
Infine, è possibile selezionare se si preferisce la consegna più veloce o il prezzo più conveniente. Di default si preferisce l'opzione con il prezzo più basso.  


Il risultato della ricerca verrà visualizzato sotto la bara di ricerca che manterrà le informazioni ricercate.  
Se 

-la ricerca è nell'immediato non si dispone della quantità richiesta  
-tenendo conto dei rifornimenti previsti entro la data del pre-ordine non si riesce a raggiungere la quantità richiesta  
verrà visualizzato:  

*1) Supplier A is not prompted because it does not have enough stock quantity available*

Se si dispone della quantità richiesta verrà visualizzato: 

###### ricerca per il prezzo basso:
\------------*|Best choise|* 
 
*1) Supplier C can fulfill the request for 12$ in 5 days*
 
\------------

*2) Supplier B can fulfill the request for 1555.68$ in 7 days* 

*3) Supplier A can fulfill the request for 3000000$ in 3 days*

###### ricerca per la consegna veloce:

*1) Supplier C can fulfill the request for 12$ in 5 days*

*2) Supplier B can fulfill the request for 1555.68$ in 7 days*

\------------|*Best choise*|  
*3) Supplier A can fulfill the request for 3000000$ in 3 days*  
\------------  
fornendo, quindi, anche le informazioni sulla consegna.

## Tecnologie

- MySQL  
- Php lato server  
- JS e JQuery lato client


## Gestione dei dati  

Per la gestione dei dati è stato creato un database relazionale MySQL con l'utilizza si phpMyAdmin
Questo contiene 5 tabelle

**SUPPLIERS** che contiene le informazioni sui fornitori con cui collabora il negozio con:
 un campo **id** AutoIncrement che funge da chiave primaria e univoca. Essendo un intero è comodo come elemento di ricerca, nel caso di necessità si potrebbe aggiungere un codice parlante.
 un campo **name** che rappresenta il nome del fornitore
 un campo **delivery** minimo giorni per una consegna

**PRODUCTS** che contiene tutti i prodotti in relazione ai fornitori e le offerte con:
un campo **id** AutoIncrement
un campo **name** che indica il prodotto, per esempio: *"radio"*
un campo **model** che indica il modello del prodotto
un campo **supplier** la chiave esterna in riferimento alla tabella **SUPPLIERS** che indica il fornito
un campo **price** che indica il prezzo del prodotto

**DISCOUNTS** che contiene tutte le offerte in corso in relazione al prodotto (di un certo fornitore) con:
un campo **id** AutoIncrement
un campo **product** chiave esterna della tabella **PRODUCTS**
un campo **code** che rappresenta il tipo di offerta ovvero su cosa si basa: 1 = quantità dei prodotti, 2 = totale della spesa minimo, 3 = mese in cui viene fatto l'acquisto
un campo **request** che indica qual è la richiesta per ottenere lo sconto, per esempio: min 5 prodotti, min 1000 di spesa, se la spesa è fatta nel mese aprile
un campo **discount** che indica la percentuale dello sconto 

**STOCK** che contiene le informazioni dei prodotti presenti nel magazzino con:
un campo **id** AutoIncrement
un campo **product** chiave esterna della tabella **PRODUCTS**
un campo **amount** che indica la quantità del prodotto presente

**RESTOCK** che contiene le informazioni dei rifornimenti del magazzino:
un campo **id** AutoIncrement
un campo **stock** chiave esterna in riferimento alla sezione del magazzino che verrà rifornita
un campo **amount** che indica di quanto è previsto il rifornimento
un campo **next** che indica la data del prossimo rifornimento previsto 


## Elaborazione dei dati

Tutto l'input è controllato:

Sul campo **prodotto** e **modello** viene eseguito il trim e si raccomanda all'utente di inserire le info se rimane vuoto
Il campo della **quantità** permette l'inserimento solo dei valori maggiori uguali a 1. Se si inserisce un valore decimale viene arrotondato per difetto. Se manca l'inserimento, si chiede all'utente di provvedere
Il campo che si riferisce al **periodo** se non modificati, vengono impostati alla data della ricerca; lo stesso avviene se il periodo inserito è precedente al momento della ricerca.
Con due bottoni radio si può selezionare la **preferenza** della ricerca, di base è sul prezzo. Un bottone con l'immagine della lente d'ingrandimento per avviare la ricerca.

Tutta la comunicazione con l'utente avviene attraverso il div "information"

Una volta recuperate le informazioni della ricerca su "RicercaHome.php", vengono inoltrate con jQuery per l'elaborazione a "Ricerca.php". Per questo bisogna include jQuery da Google  `<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>` 

Il file php si connette al database.  
Si esegue la prima query di ricerca con i dati forniti dall'utente.  
Se il risultato è una tabella contenente almeno una riga si crea un array associativo.  

Si analizza ogni riga e si concatena l'output in una variabile **$S** che verrà inoltrata all'utente. Per valutare se il fornitore soddisfa la richiesta vengono utilizzate diverse funzioni.  
coutnDays che prende come parametro il periodo inserito dall'utente e calcola quanti giorni si ha a disposizione dalla data di ricerca.   
totalPrice che calcola il prezzo tenendo conto delle offerte. 
Si tiene conto anche di eventuali restock con una query **$sqlRestock**, in caso la quantità richiesta non sia raggiungibile. Questa querry interoga le tabelle dello **STOCK** e **RESTOCK** controllando per quando sono previsti i rifornimenti e di quanto.   

A ogni passaggio dell'elemento dell'array associativo che contiene le informazioni della ricerca, il prezzo e la consegna vengono confrontati con l'occasione migliore dei precedenti memorizzati in **$bestChoice** e, se ritenuti migliori, l'occasione viene memorizzata in **$bestChoice** a sua volta sostituendo quella precedente. Al primo elemento di array, non avendo dati precedenti con cui essere confrontato, i valori di confronto vengono impostati al massimo rendendo così la prima riga dell'array **$bestChoice** e avviando il confronto tra i risultati della query.  

Prima di inviare i dati all'utente nella variabile che concatena tutti gli output la variabile **$bestChoice** viene sostituita con la variabile stessa preceduta e seguita in modo da evidenziare l'occasione migliore.  

Viene richiamato **sleep** per un secondo per una questione psicologica.  
Si chiude la connessione con il database.  
