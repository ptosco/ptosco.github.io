var url = 'https://ptosco.github.io/test_phantomjs.html';

var page = require('webpage').create();
page.viewportSize = { width: 600, height: 1080 };
page.paperSize = {
    format: 'A3',
    orientation: 'landscape',
    margin: '20px'
};
page.settings.dpi = "300";
var interval = {
    count: 0,
    MAX_COUNT: 200
};
page.open(url, function() {
    interval.id = setInterval(function() {
        var content = page.content;
        var isRenderingFinished = (typeof content === 'string'
            && content.indexOf('rect') !== -1
            && content.indexOf('div class="rdk-str-rnr-spinner" style="display: block;"') === -1);
        if (isRenderingFinished || (++interval.count === interval.MAX_COUNT)) {
            if (interval.id) {
                clearInterval(interval.id);
            }
            if (!isRenderingFinished) {
                console.log('Timeout before rendering was finished');
            }
            page.render('renderer.pdf', { format: 'pdf', quality: '100' });
            phantom.exit();
        }
    }, 2000);
});
