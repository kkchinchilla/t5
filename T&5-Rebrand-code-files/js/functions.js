
const query = (options) => {
	return fetch('../data/api.php',{
		method:'POST',
		body: JSON.stringify(options),
		headers:{'Content-Type':'application/json'}
	}).then(d=>d.json());
}