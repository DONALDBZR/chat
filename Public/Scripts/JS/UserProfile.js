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
            }));
        fetch("/Contacts/Get", {
            method: "GET"
        })
            .then((response) => response.json())
            .then((data) => this.setState({
                message: data.message,
                contacts: data.contacts,
                class: data.class,
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
                <Profile />
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
                <div class="link">
                    <a href={this.state.profile} class="fa fa-user"></a>
                </div>
                <div class="link">
                    <a href="/Sign-Out" class="fa fa-sign-out"></a>
                </div>
            </nav>
        );
    }
}
/**
 * The profile component of the application which display all the details about the current user
 */
class Profile extends Main {
    constructor(props) {
        super(props);
    }
    /**
     * Counting all the contacts that the current user has
     * @returns {int} Amount of contacts
     */
    countContacts() {
        return this.state.contacts.length;
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <div id="profile">
                <div id="header">
                    <div>Profile Picture</div>
                    <div>
                        <a href="./Edit">Edit</a>
                    </div>
                </div>
                <div id="username">{this.state.username}</div>
                <div id="mailAddress">
                    <a href={"mailto:" + this.state.mailAddress}>{this.state.mailAddress}</a>
                </div>
                <div id="contacts"><div id="amountContacts">{this.countContacts()}</div> contacts</div>
            </div>
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
ReactDOM.render(<Application />, document.getElementById("userProfile"));