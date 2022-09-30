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
    }
    /**
     * @returns {string}
     */
    getRequestUniformRequestInformation() {
        return this.__requestUniformRequestInformation;
    }
    /**
     * 
     * @param {string} request_uniform_information 
     */
    setRequestUniformInformation(request_uniform_information) {
        this.__requestUniformRequestInformation = request_uniform_information;
    }
}