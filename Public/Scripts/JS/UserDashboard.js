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
        };
    }
    /**
     * Retrieving the Session data that is stored in the JSON to be used on the front-end
     */
    retrieveData() {
        Promise.all([
            fetch("/Users/CurrentUser", {
                method: "GET"
            }),
            fetch("/Contacts", {
                method: "GET"
            })
        ])
            .then(([currentUser, contacts]) => {
                const currentUserJSON = currentUser.json()
                const contactsJSON = contacts.json()
                return [currentUserJSON, contactsJSON]
            })
            .then((data) => {
                data[0]
                    .then((currentUser) => this.setState({
                        username: currentUser.username,
                        mailAddress: currentUser.mailAddress,
                        domain: currentUser.domain,
                        home: `/Users/Dashboard/${currentUser.username}`,
                        profile: `/Users/Profile/${currentUser.username}`,
                        security: `/Users/Account/${currentUser.username}`,
                        profilePicture: currentUser.profilePicture
                    }))
                data[1]
                    .then((contacts) => this.setState({
                        message: contacts.message,
                        contacts: contacts.contacts,
                        class: contacts.class,
                    }))
            });
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
                <Contacts />
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
 * The contacts component of the application which display all the contacts that the user currently have
 */
class Contacts extends Main {
    constructor(props) {
        super(props);
    }
    /**
     * Verifying whether a profile picture exists
     * @param {string|null} UserProfilePicture
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
     * Ensuring that the contact name of the current user is actually being rendered.
     * @param {string} user
     * @param {string} friend
     * @returns {string}
     */
    getName(user, friend) {
        if (user != this.state.username) {
            return user;
        } else {
            return friend;
        }
    }
    /**
     * Verifying whether there is a contact before rendering the correct state
     * @returns {JSX}
     */
    getContact() {
        if (this.state.contacts.length > 0) {
            return (
                <div class={this.state.class}>
                    {
                        this.state.contacts.map(
                            (contact) => <div class={"user_" + this.getName(contact.user, contact.friend)}>
                                <div class="profilePicture">
                                    {this.verifyProfilePicture(contact.profilePicture)}
                                </div>
                                <div class="userDetails">
                                    <div class="username">
                                        <h1>{this.getName(contact.user, contact.friend)}</h1>
                                    </div>
                                    <div class="messageButton">
                                        <a href={"/Messages/" + this.state.username + "/" + this.getName(contact.user, contact.friend)} class="fa fa-envelope"></a>
                                    </div>
                                </div>
                            </div>
                        )
                    }
                </div>
            );
        } else {
            return (
                <div class={this.state.class}>{this.state.message}</div>
            );
        }
    }
    /**
     * Returning components to the DOM for them to be rendered
     * @returns {Application} Components
     */
    render() {
        return (
            <div id="contacts">
                <h1>Contact List</h1>
                {this.getContact()}
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
ReactDOM.render(<Application />, document.getElementById("userDashboard"));