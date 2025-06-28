/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.globals = {
    data: {
        title: 'Home Page',
        modules: [],
        loader: [],
    },
    init() {
        this.onStart();
    },
    onStart() {
        var self = globals;
        console.log('globals:onStart');

        self.listeners();
        self.modules.init();
    },
    onLoad: {

    },
    listeners() {
        var self = globals;

    },
    get_data() {},
    //------------
    cookies: {
        set(cname, cvalue, exdays) {

            if (exdays == undefined) {
                exdays = ((new Date).getTime() * 24 * 60 * 60 * 1000);
            }

            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        get(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');

            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        has(name) {
            var user = globals.cookies.get(name);

            if (user != "") {
                //alert("Welcome again " + user);
                return true;
            } else {
                return false;
            }

            return false;
        },
        remove(name) {
            document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';

            return true;
        }
    },
    //------------
    /**
     * Get the URL parameters
     * source: https://css-tricks.com/snippets/javascript/get-url-variables/
     * @param {String} url The URL
     * @return {Object} The URL parameters
     */
    get_url_params(url) {
        var params = {};
        var parser = document.createElement('a');
        parser.href = url;
        var query = parser.search.substring(1);
        var vars = query.split('&');

        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }

        return params;
    },
    goto(path) {
        window.location.href = base_url + `${path}`;
    },
    loader: {
        show() {
            $('.overlay').show();
        },
        hide() {
            $('.overlay').hide();
        },
        add(state) {
            let self = globals;
            let found = false;

            $.each(self.data.loader, (dx, vx) => {
                if (vx == state)
                    found = true;
            });

            if (!found)
                globals.data.loader.push(state);

            if (globals.data.loader.length > 0) {
                globals.loader.show();
            }
        },
        remove(state) {
            let self = globals;
            let temp = [];

            $.each(self.data.loader, (dx, vx) => {
                if (vx != state)
                    temp.push(vx);
            });

            self.data.loader = temp;

            if (globals.data.loader.length == 0) {
                globals.loader.hide();
            }
        },
        check() {
            let self = globals;

            /*setInterval(() => {
             if (globals.data.loader.length > 0) {
             globals.loader.show();
             }
             if (globals.data.loader.length == 0) {
             globals.loader.hide();
             }
             //console.log(globals.data.loader);
             }, 0.3 * 1000);*/
        },
    },
    modules: {
        attach(module) {
            var self = globals;

            self.data.modules.push(module);
        },
        init() {
            var self = globals;

            $.each(self.data.modules, function (indx, module) {
                module.init();
            });
        },
    },
    slugify(str) {
        return String(str)
                .normalize('NFKD') // split accented characters into their base characters and diacritical marks
                .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
                .trim() // trim leading or trailing whitespace
                .toLowerCase() // convert to lowercase
                .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
                .replace(/\s+/g, '-') // replace spaces with hyphens
                .replace(/-+/g, '-'); // remove consecutive hyphens
    },
};

window.Arrys = {
    /**
     * 
     * <pre>
     * This function checks if a value exists in an array
     * </pre>
     * 
     * @param {type} key
     * @param {type} value
     * @param {type} array
     * @returns {Boolean}
     */
    exists(key, value, array) {
        let st = false;

        $.each(array, (k, E) => {
            console.log(key, E[key], value);

            if (E[key] == value) {
                st = true;
                return;
            }
        });

        return st;
    },
    /**
     * 
     * <pre>
     * This function checks if a KEY exists in an array
     * </pre>
     * 
     * @param {type} key
     * @param {type} value
     * @param {type} array
     * @returns {Boolean}
     */
    key_exists(key, array) {
        let st = false;

        $.each(array, (k, E) => {
            console.log(key, k, E);

            if (k == key) {
                st = true;
                return;
            }
        });

        return st;
    },
};

window.addEventListener('load', function () {
    globals.init();
});

