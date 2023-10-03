function filtro(event) {
    var texto = event.key;
    if ([',', 'e', 'E'].includes(texto))
        event.preventDefault()
}
function limitarInput(input, maxLength) {
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}