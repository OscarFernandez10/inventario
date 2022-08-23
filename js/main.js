function NumText(string){//solo letras y numeros
	return string.replace(/[^0-9abcdABCD]/g, '');
}