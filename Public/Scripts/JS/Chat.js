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
        /**
         * Stylesheets of the application
         * @type {string[]}
         */
        this._stylesheets = [
            "/Public/Stylesheets/chat.css",
            "/Public/Stylesheets/desktop.css",
            "/Public/Stylesheets/mobile.css",
            "/Public/Stylesheets/tablet.css"
        ];
        /**
         * Relationship of the object
         * @type {string}
         */
        this.__relationship;
        /**
         * MIME Type of the object
         * @type {string}
         */
        this.__mimeType;
        /**
         * @type {string[]}
         */
        this._mediaQueries = [
            "screen and (min-width: 1024px)",
            "screen and (min-width: 640px) and (max-width: 1023px)",
            "screen and (max-width: 639px)"
        ];
        this.init();
    }
    /**
     * @returns {string}
     */
    getRequestUniformInformation() {
        return this.__requestUniformRequestInformation;
    }
    /**
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
     * @param {string} body_id 
     */
    setBodyId(body_id) {
        this.__bodyId = body_id;
    }
    /**
     * @returns {string}
     */
    getRelationship() {
        return this.__relationship;
    }
    /**
     * @param {string} relationship 
     */
    setRelationship(relationship) {
        this.__relationship = relationship;
    }
    /**
     * @returns {string}
     */
    getMimeType() {
        return this.__mimeType;
    }
    /**
     * @param {string} mime_type 
     */
    setMimeType(mime_type) {
        this.__mimeType = mime_type;
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
        this.style();
    }
    /**
     * Styling the application
     */
    style() {
        this.setRelationship("stylesheet");
        this.setMimeType("text/css");
        for (let firstIndex = 0; firstIndex < this._stylesheets.length; firstIndex++) {
            const link = document.createElement("link");
            link.href = this._stylesheets[firstIndex];
            if (link.href.includes("desktop")) {
                link.media = this._mediaQueries[0];
            } else if (link.href.includes("mobile")) {
                link.media = this._mediaQueries[2];
            } else if (link.href.includes("tablet")) {
                link.media = this._mediaQueries[1];
            }
            link.rel = this.getRelationship();
            link.type = this.getMimeType();
            document.head.appendChild(link);
        }
    }
}
const application = new Chat();