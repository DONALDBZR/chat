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
             * The link to the dashboard of the user
             */
            home: "",
            /**
             * The link to the profile of the user
             */
            profile: "",
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
            /**
             * The contacts of the current user
             */
            contacts: [],
            /**
             * The class of the html element
             */
            class: "",
            /**
             * Profile Picture of the user
             */
            profilePicture: "",
        };
    }
    /**
     * Retrieving the Session data that is stored in the JSON to be used on the front-end
     */
    retrieveData() {
        fetch("/User", {
            method: "GET"
        })
            .then((response) => response.json())
            .then((data) => this.setState({
                username: data.username,
                mailAddress: data.mailAddress,
                password: data.password,
                domain: data.domain,
                home: `/User/Dashboard/${data.username}`,
                profile: `/User/Profile/${data.username}`,
                security: `/User/Account/${data.username}`,
                profilePicture: data.profilePicture,
            }));
    }
    /**
     * 1. Retrieving the session data as soon as the component is mount
     */
    componentDidMount() {
        this.retrieveData();
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
        const delay = 3760;
        event.preventDefault();
        fetch("/Controllers/Register.php", {
            method: "POST",
            body: JSON.stringify({
                username: this.state.username,
                mailAddress: this.state.mailAddress,
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
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return [<Header />, <Main />, <Footer />];
    }
}
/**
 * The header component of the application which has the header tag as parent
 */
class Header extends Application {
    constructor(props) {
        super(props);
        /**
         * The states of the properties of the component
         */
        this.state = {
            /**
             * The clock of the component
             */
            time: new Date()
        };
    }
    /**
     * This method will update the time for each second
     */
    update() {
        setInterval(() => {
            this.setState({
                time: new Date()
            });
        }, 1000);
    }
    componentDidMount() {
        this.update();
    }
    componentWillUnmount() {
        clearInterval();
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <header>
                <Clock />
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
            <main>
                <NavigationBar />
                <Form />
            </main>
        );
    }
}
/**
 * The navigation bar component of the application which has the nav tag as parent
 */
class NavigationBar extends Main {
    constructor(props) {
        super(props);
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <nav>
                <div class="link">
                    <a href={this.state.home} class="fa fa-home"></a>
                </div>
                <ProfileLink />
                <div class="link">
                    <a href={this.state.security} class="fa fa-cog"></a>
                </div>
                <div class="link">
                    <a href="/Sign-Out" class="fa fa-sign-out"></a>
                </div>
            </nav >
        );
    }
}
/**
 * The component which renders the profile link depending on the state of the profile picture.
 */
class ProfileLink extends NavigationBar {
    constructor(props) {
        super(props);
    }
    /**
     * Verifying the state before rendering the anchor tag needed
     * @returns {JSX} Component
     */
    verifyState() {
        if (this.state.profilePicture != null) {
            return (
                <a href={this.state.profile}>
                    <img src={this.state.profilePicture} />
                </a>
            );
        } else {
            return <a href={this.state.profile} class="fa fa-user"></a>;
        }
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <div class="link">
                {this.verifyState()}
            </div>
        );
    }
}
/**
 * The form component of the application which allows the user to edit his/her profile
 */
class Form extends Main {
    constructor(props) {
        super(props);
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <form method="POST" onSubmit={this.handleSubmit.bind(this)}>
                <div id="header">Account Settings</div>
                <div id="username">
                    <div class="label">Username: </div>
                    <div class="input">
                        <input
                            type="text"
                            name="username"
                            value={this.state.username}
                            onChange={this.handleChange.bind(this)}
                            disabled
                        />
                    </div>
                </div>
                <div id="mailAddress">
                    <div class="label">Mail Address: </div>
                    <div class="input">
                        <input
                            type="email"
                            name="mailAddress"
                            value={this.state.mailAddress}
                            onChange={this.handleChange.bind(this)}
                            disabled
                        />
                    </div>
                </div>
                <div id="oldPassword">
                    <div class="label">Old Password: </div>
                    <div class="input">
                        <input
                            type="password"
                            name="oldPassword"
                            value={this.state.oldPassword}
                            onChange={this.handleChange.bind(this)}
                        />
                    </div>
                </div>
                <div id="newPassword">
                    <div class="label">New Password: </div>
                    <div class="input">
                        <input
                            type="password"
                            name="newPassword"
                            value={this.state.newPassword}
                            onChange={this.handleChange.bind(this)}
                        />
                    </div>
                </div>
                <div id="confirmNewPassword">
                    <div class="label">Confirm New Password: </div>
                    <div class="input">
                        <input
                            type="password"
                            name="confirmNewPassword"
                            value={this.state.confirmNewPassword}
                            onChange={this.handleChange.bind(this)}
                        />
                    </div>
                </div>
                <div id="button">
                    <button>Change</button>
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
/**
 * The clock component of the application which will be a digital clock which will be the child of the Header component
 */
class Clock extends Header {
    constructor(props) {
        super(props);
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <div id="clock">{this.state.time.toLocaleTimeString('en-GB')}</div>
        );
    }
}
// Rendering page
ReactDOM.render(<Application />, document.getElementById("userAccount"));