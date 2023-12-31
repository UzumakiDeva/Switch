var http = require('http'),
qs = require('querystring');
var server = http.createServer(function(req, res) {
	if (req.method === 'POST') {
		var body = '';
		req.on('data', function(chunk) {
			body += chunk;
		});
		req.on('end', function() {
		var data = JSON.parse(body);
		//tron web declaration
		var TronWeb = require('tronweb')
		var HttpProvider = TronWeb.providers.HttpProvider;
		var fullNode = new HttpProvider("https://api.trongrid.io");
		var solidityNode = new HttpProvider("https://api.trongrid.io");
		var eventServer = new HttpProvider("https://api.trongrid.io");
		if(data.method === 'send_trc'){
			async function sendTx() {
				try
				{
					var privateKey = data.pvtk;
					var tronWeb = new TronWeb(fullNode,solidityNode,eventServer,privateKey); 
					var trc20ContractAddress = data.contract;
					var contract = await tronWeb.contract().at(trc20ContractAddress);
					var tx = contract.transfer(data.to_address, data.amount).send({
						feelimit: data.fee_limit
					}).then(output => {
						var obj = {
							"txid" : output
						};
						res.writeHead(200);
						res.end(JSON.stringify(obj));
					}
					);
				}
				catch (e) { console.log(e); }
			}
			sendTx();
		}
	});
	} else {
		res.writeHead(404);
		res.end();
	}
});
server.listen(8647, '165.227.166.121');