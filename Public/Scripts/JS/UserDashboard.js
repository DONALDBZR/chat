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
        };
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
            home: `/User/Dashboard/${data.username}`,
            profile: `/User/Profile/${data.username}`,
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
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <header>
                <NavigationBar />
            </header>
        );
    }
}
/**
 * The navigation bar component of the application othe header which has the nav tag as parent
 */
class NavigationBar extends Header {
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
                <div id="home">
                    <a href={this.state.home}>
                        <i class="fa fa-home"></i>
                    </a>
                </div>
                <div id="profile">
                    <a href={this.state.profile}>
                        <i class="fa fa-user"></i>
                    </a>
                </div>
                <div id="logout">
                    <a href="/Sign-Out">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </div>
            </nav>
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