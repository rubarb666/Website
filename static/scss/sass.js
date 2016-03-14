var sass = require('node-sass');
var fs = require('fs');

var files = ['screen', 'ie'];
for (var i = 0; i < files.length; i++) {	
	render(files[i], '../css/' + files[i] + '.css');
}

function render(fileName, cssFile) {

	console.log('Rendering ' + fileName + '.scss to ' + cssFile);

	sass.render({
	  file: fileName + '.scss',
	  outFile: cssFile,
	  sourceMap: true,
	  //outputStyle: 'compressed'

	}, function(err, result) {

		if (err){
			console.log(err);
		} else {
			fs.writeFile(cssFile, result.css);
		}
	});
}