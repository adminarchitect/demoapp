window.Vue = require('vue');

Vue.filter('truncate', (value, length) => {
    const l = value.length;

    return value.substr(0, length) + ((l > length) ? '...' : '');
});

Vue.component('MediaManager', require('./components/MediaManager.vue'));
Vue.component('MediaCarousel', require('./components/MediaCarousel.vue'));

Vue.component('FoldersList', require('./components/Folders.vue'));
Vue.component('FilesList', require('./components/Files.vue'));
Vue.component('FileInfo', require('./components/FileInfo.vue'));
Vue.component('FileActions', require('./components/FileActions.vue'));
Vue.component('DropZone', require('./components/DropZone.vue'));

// Popups
Vue.component('MakeDirPopup', require('./components/popups/MkDir.vue'));
Vue.component('MovePopup', require('./components/popups/Move.vue'));
Vue.component('RenamePopup', require('./components/popups/Rename.vue'));

// Partials
Vue.component('ModalFooter', require('./components/partials/ModalFooter.vue'));
Vue.component('ModalHeader', require('./components/partials/ModalHeader.vue'));
