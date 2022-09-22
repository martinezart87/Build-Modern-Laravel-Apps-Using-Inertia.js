export default class User {
    constructor(attributes = {}) {
        Object.assign(this, attributes);
    }

    follows(user) {
        return true;

        return this.follows.includes(user.id);
    }

    is(user) {
        return this.id === user.id;
    }

    hasPrivateProfile() {

    }

    isAlifer() {
        return false;
    }

}
