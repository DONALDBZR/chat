/**
 * The application that is going to be rendered by React.js.
 */
class Application extends React.Component {
    /**
     * Adding the main stylesheet to the Application
     */
    mainStylesheet() {
        const link = document.createElement("link");
        link.href = "/Public/Stylesheets/chat.css";
        link.rel = "stylesheet";
        link.type = "text/css";
        document.head.appendChild(link);
    }
    /**
     * Adding the media queries stylesheets to the Application
     */
    mediaQueriesStylesheets() {
        const stylesheets = ["/Public/Stylesheets/desktop.css", "/Public/Stylesheets/tablet.css", "/Public/Stylesheets/mobile.css"];
        const mediaQueries = ["screen and (min-width: 1024px)", "screen and (min-width: 640px) and (max-width: 1023px)", "screen and (max-width: 639px)"];
        for (let index = 0; index < stylesheets.length; index++) {
            const link = document.createElement("link");
            link.href = stylesheets[index];
            link.media = mediaQueries[index];
            link.rel = "stylesheet";
            link.type = "text/css";
            document.head.appendChild(link);
        }
    }
    componentDidMount() {
        this.mainStylesheet();
        this.mediaQueriesStylesheets();
    }
    render() {
        return <Header />;
    }
}
/**
 * The header component of the application which has the header tag as parent
 */
class Header extends Application {
    render() {
        return (
            <header>
                <h1 id="code">404</h1>
                <h1>not found</h1>
            </header>
        );
    }
}
// Rendering page
ReactDOM.render(<Application />, document.getElementById("404"));