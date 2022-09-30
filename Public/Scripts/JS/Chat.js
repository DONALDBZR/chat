/**
 * The class that have all the scripts that need to be run before the application is mounted
 */
class Chat {
    constructor() {
        /**
         * The request URI of the page needed
         * @type {string}
         */
        this.__requestUniformRequestInformation;
        /**
         * The ID of the body
         * @type {string}
         */
        this.__bodyId;
        this.init();
    }
    /**
     * @returns {string}
     */
    getRequestUniformInformation() {
        return this.__requestUniformRequestInformation;
    }
    /**
     * 
     * @param {string} request_uniform_information 
     */
    setRequestUniformInformation(request_uniform_information) {
        this.__requestUniformRequestInformation = request_uniform_information;
    }
    /**
     * @returns {string}
     */
    getBodyId() {
        return this.__bodyId;
    }
    /**
     * 
     * @param {string} body_id 
     */
    setBodyId(body_id) {
        this.__bodyId = body_id;
    }
    /**
     * It will initialize the application
     */
    init() {
        const body = document.getElementsByTagName("body")[0];
        this.setRequestUniformInformation(window.location.pathname);
        if (this.getRequestUniformInformation() == "/") {
            this.setBodyId("Homepage");
        } else {
            this.setBodyId(this.getRequestUniformInformation().replace("/", ""));
        }
        body.id = this.getBodyId();
    }
}