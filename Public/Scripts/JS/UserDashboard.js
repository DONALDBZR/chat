/**
 * The application that is going to be rendered by React.js.
 */
class Application extends React.Component {
    constructor(props) {
        super(props);
        /**
         * The states of the properties of the component
         */
        this.state = {
            /**
             * Username of the user
             */
            username: "",
            /**
             * Mail Address of the user
             */
            mailAddress: "",
            /**
             * Password of the user
             */
            password: "",
            /**
             * Domain of the application
             */
            domain: "",
            /**
             * An HTML's id attribute that will be used for rendering the message that will be displayed to the user
             */
            success: "",
            /**
             * The message that will be displayed to the user
             */
            message: "",
            /**
             * the url to be redirected after displying the message
             */
            url: "",
        };
    }
    /**
     * Handling any change that is made in the user interface
     * @param {Event} event 
     */
    handleChange(event) {
        const target = event.target;
        const value = target.value;
        const name = target.name;
        this.setState({
            [name]: value,
        });
    }
    /**
     * Handling the form submission firstly preventing default submission before generating the JSON that will be sent to the back-end before retrieving a JSON as a response which contains the message and the destination to send the user.
     * @param {Event} event 
     */
    handleSubmit(event) {
        /**
         * The amount of milliseconds that the registration process takes
         */
        const delay = 2525;
        event.preventDefault();
        fetch("/Controllers/Register.php", {
            method: "POST",
            body: JSON.stringify({
                username: this.state.username,
                mailAddress: this.state.mailAddress,
                password: this.state.password,
                confirmPassword: this.state.confirmPassword,
            }),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => this.setState({
                success: data.success,
                message: data.message,
                url: data.url,
            }))
            .then(() => this.redirector(delay));
    }
    /**
     * Redirecting the user to an intended url
     * @param {int} delay 
     */
    redirector(delay) {
        setTimeout(() => {
            window.location.href = this.state.url;
        }, delay);
    }
    /**
     * Retrieving the Session data that is stored in the JSON to be used on the front-end
     */
    retrieveData() {
        fetch("/User", {
            method: "GET"
        }).then((response) => response.json()).then((data) => this.setState({
            username: data.username,
            mailAddress: data.mailAddress,
            password: data.password,
            domain: data.domain,
        }));
    }
    /**
     * 1. Retrieving the session data as soon as the component is mount
     */
    componentDidMount() {
        this.retrieveData();
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        console.log(`Username: ${this.state.username}\nMail Address: ${this.state.mailAddress}\nPassword: ${this.state.password}\nDomain: ${this.state.domain}\n`);
        return [<Header />, <Main />, <Footer />];
    }
}
/**
 * The header component of the application which has the header tag as parent
 */
class Header extends Application {
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        /**
         * The link to the dashboard of the user
         */
        const home = `/User/Dashboard/${this.state.username}`;
        /**
         * The link to the profile of the user
         */
        const profile = `/User/Profile/${this.state.username}`;
        return (
            <header>
                <nav>
                    <div id="home">
                        <a href={home}>
                            <i class="fa fa-home"></i>
                        </a>
                    </div>
                    <div id="profile">
                        <a href={profile}>
                            <i class="fa fa-user"></i>
                        </a>
                    </div>
                    <div id="logout">
                        <a href="/Sign-Out">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </div>
                </nav>
            </header>
        );
    }
}
/**
 * The main component of the application which has the main tag as parent
 */
class Main extends Application {
    constructor(props) {
        super(props);
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <main></main>
        );
    }
}
/**
 * The footer component of the application which has the footer tag as parent
 */
class Footer extends Application {
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <footer></footer>
        );
    }
}
// Rendering page
ReactDOM.render(<Application />, document.getElementById("userDashboard"));