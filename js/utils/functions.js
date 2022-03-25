// Example POST method implementation:
export async function postData(url = '', data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, *cors, same-origin
      cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        'Content-Type': 'application/json'
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow', // manual, *follow, error
      referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
  }
  
// Example POST method implementation:
export async function postForm(url = '', form) {
  const response = await fetch(url, {
    method: 'POST',
    body: form,
  });
  return response.json();

  /********* XML VERSION  **********************/
  /*let XHR = new XMLHttpRequest();
  XHR.addEventListener("load", function(event) {
    return event.target.responseText;
  });
   // Definissez ce qui se passe en cas d'erreur
   XHR.addEventListener("error", function(event) {
    return 'Error';
  });
  // Configurez la requête
  XHR.open("POST", url);

  // Les données envoyées sont ce que l'utilisateur a mis dans le formulaire
  XHR.send(form);*/
}