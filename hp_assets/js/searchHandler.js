var cmdPrefix = "!";
var ssi = 0;
var searchSources = [
    ["g", "https://www.google.com/search?q={Q}", "Google"],
    ["so", "https://www.stackoverflow.com/search?q={Q}", "Stack Overflow"],
    ["r", "https://www.google.com/search?q=inurl:reddit.com%22{Q}", "Reddit"],
    ["sh", "https://www.shodan.io/search?query={Q}", "Shodan"],
    ["d", "https://duckduckgo.com/?q={Q}", "DuckDuckGo"],
    ["av", "https://www.google.com/search?q=intext:%22{Q}%22+(avi|mkv|mov|mp4|mpg|wmv|ac3|flac|m4a|mp3|ogg|wav|wma)+-inurl:(jsp|pl|php|html|aspx|htm|cf|shtml)+-inurl:(index_of|listen77|mp3raid|mp3toss|mp3drug|index_of|wallywashis)+intitle:%22index.of./%22", "Audio/Video"],
    ["sa", "https://www.google.com/search?q=intext:%22{Q}%22+(apk|exe|dmg|iso|tar|7z|bz2|gz|iso|rar|zip)+-inurl:(jsp|pl|php|html|aspx|htm|cf|shtml)+-inurl:(index_of|listen77|mp3raid|mp3toss|mp3drug|index_of|wallywashis)+intitle:%22index.of./%22", "Software/Archive"]
];

function handleQuery(event, query) {
    var key = event.keyCode || event.which;
    if (query !== "") {
        if (key === 32) { // space
            qList = query.split(" ");
            if (qList[0].charAt(0) === cmdPrefix) {
                var keyword = "";
                for (var i = 0; i < searchSources.length; i++) {
                    keyword = cmdPrefix + searchSources[i][0];
                    if (keyword === qList[0]) {
                        ssi = i;
                        searchInput.placeholder = searchSources[ssi][2];
                        searchInput.value = query.replace(keyword, "").trim();
                        searchsave = ssi;
                        event.preventDefault();
                        break;
                    }
                }
            }
        } else if (key === 13) { // enter
            qList = query.split(" ");
            if (qList[0].charAt(0) === cmdPrefix) {
                var keyword = "";
                for (var i = 0; i < searchSources.length; i++) {
                    keyword = cmdPrefix + searchSources[i][0];
                    if (keyword === qList[0]) {
                        ssi = i;
                        break;
                    }
                }
                if (qList.length > 1) {
                    window.location = searchSources[ssi][1].replace("{Q}", encodeURIComponent(query.replace(keyword, ""))).trim();
                } else {
                    searchInput.placeholder = searchSources[ssi][2];
                    searchInput.value = "";
                }
            } else {
                window.location = searchSources[ssi][1].replace("{Q}", encodeURIComponent(query));
            }
        }
    }
    if (key === 27) { // esc
        searchInput.blur();
    }
}