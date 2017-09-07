import {loader} from 'zjs/loader';

loader.on('login.load', elem => {
    import(`./page/${elem.getAttribute('data-page')}.js`);
});
