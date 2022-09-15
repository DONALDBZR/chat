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
            /**
             * Records returned by the database
             */
            users: [],
            /**
             * The data that is entered by the user
             */
            input: "",
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
                domain: data.domain,
                home: `/User/Dashboard/${data.username}`,
                profile: `/User/Profile/${data.username}`,
                security: `/User/Account/${data.username}`,
                profilePicture: data.profilePicture,
            }));
        fetch("/Users", {
            method: "GET"
        })
            .then((response) => response.json())
            .then((data) => this.setState({
                users: data.users,
            }));
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
        event.preventDefault();
        fetch("/Controllers/UsersSearch.php", {
            method: "GET",
            body: JSON.stringify({
                input: this.state.input,
            }),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => this.setState({
                success: data.success,
                message: data.message,
                users: data.users,
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
                <div class="link">
                    <a href="/Users/Search" class="fa fa-search"></a>
                </div>
                <ProfileLink />
                <div class="link">
                    <a href={this.state.security} class="fa fa-cog"></a>
                </div>
                <div class="link">
                    <a href="/Sign-Out" class="fa fa-sign-out"></a>
                </div>
            </nav>
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
 * The component which will act like a form
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
            <div id="searchForm">
                <SearchBar />
                <ServerRendering />
            </div>
        );
    }
}
/**
 * The component which allows the user to search for any user that is in the application
 */
class SearchBar extends Form {
    constructor(props) {
        super(props);
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <form method="GET" onSubmit={this.handleSubmit.bind(this)}>
                <input
                    type="search"
                    name="input"
                    placeholder="Search..."
                    value={this.state.input}
                    onChange={this.handleChange.bind(this)}
                />
                <button class="fa fa-search"></button>
            </form>
        );
    }
}
/**
 * The component which will render the data from the back-end
 */
class ServerRendering extends Form {
    constructor(props) {
        super(props);
    }
    /**
     * Verifying whether a profile picture exists
     * @param {string} UserProfilePicture
     * @return {JSX} Component
     */
    verifyProfilePicture(UserProfilePicture) {
        if (UserProfilePicture != null) {
            return <img src={UserProfilePicture} />;
        } else {
            return <i class="fa fa-user"></i>;
        }
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <div id="serverRendering">
                {
                    this.state.users.map(
                        (user) => <div class={"user_" + user.username}>
                            <div class="profilePicture">
                                {this.verifyProfilePicture(user.profilePicture)}
                            </div>
                            <div class="userDetails">
                                <div class="username">
                                    <h1>{user.username}</h1>
                                </div>
                                <div class="details">
                                    <div class="mailAddress">{user.mailAddress}</div>
                                    <div class="addButton">
                                        <button>Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )
                }
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
ReactDOM.render(<Application />, document.getElementById("usersSearch"));