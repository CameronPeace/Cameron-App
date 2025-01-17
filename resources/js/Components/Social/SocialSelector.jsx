
import Youtube from "./Youtube";
export default function SocialSelector({ type }) {
    
    const selectSocialEvent = (type) => {
        switch (type) {
            case 'youtube':
                return <Youtube />
            default:
                return <Youtube />
        }
    }
    return (
        <>
            {selectSocialEvent(type)}
        </> 
    );
}
