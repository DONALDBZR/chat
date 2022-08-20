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
            confirmPassword: "",
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
    render() {
        return [<Header />, <Main />, <Footer />];
    }
}
/**
 * The header component of the application which has the header tag as parent
 */
class Header extends Application {
    render() {
        return (
            <header>
                <div>
                    <a href="/">Chat</a>
                </div>
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
    render() {
        return (
            <main>
                <Form />
            </main>
        );
    }
}
/**
 * The form component of the application which has the form tag as parent
 */
class Form extends Main {
    constructor(props) {
        super(props);
    }
    render() {
        return (
            <form method="POST" onSubmit={this.handleSubmit.bind(this)}>
                <div id="username">
                    <div class="label">Username:</div>
                    <div>
                        <input
                            type="text"
                            name="username"
                            placeholder="Username"
                            value={this.state.username}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                    </div>
                </div>
                <div id="mailAddress">
                    <div class="label">Mail Address:</div>
                    <div>
                        <input
                            type="text"
                            name="mailAddress"
                            placeholder="Mail Address"
                            value={this.state.mailAddress}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                    </div>
                </div>
                <div id="password">
                    <div class="label">Password:</div>
                    <div>
                        <input
                            type="password"
                            name="password"
                            placeholder="Password"
                            value={this.state.password}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                    </div>
                </div>
                <div id="confirmPassword">
                    <div class="label">Confirm Password:</div>
                    <div>
                        <input
                            type="password"
                            name="confirmPassword"
                            placeholder="Confirm Password"
                            value={this.state.confirmPassword}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                    </div>
                </div>
                <div id="button">
                    <button>Register</button>
                </div>
                <div id="serverRendering">
                    <h1 id={this.state.success}>{this.state.message}</h1>
                </div>
            </form>
        );
    }
}
/**
 * The footer component of the application which has the footer tag as parent
 */
class Footer extends Application {
    // Render method
    render() {
        return (
            <footer>
                If, you already have an account, you can click <a href="/Login">here</a> to login.
            </footer>
        );
    }
}
// Rendering page
ReactDOM.render(<Application />, document.getElementById("register"));