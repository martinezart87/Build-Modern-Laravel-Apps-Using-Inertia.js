export default class User {
    constructor(attributes = {}) {
        Object.assign(this, attributes);
    }

    follows(user) {
        return true;

        return this.follows.includes(user.id);
    }

}
