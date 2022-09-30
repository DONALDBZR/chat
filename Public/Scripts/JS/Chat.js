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
}