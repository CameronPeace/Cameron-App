
export default function Youtube() {
    return (
        <div className="py-12 flex">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <iframe
                        width="560"
                        height="315"
                        src="https://www.youtube.com/embed/294o6oo2soQ?si=M0HaQtq8DR3_kv5c" t
                        itle="YouTube video player"
                        frameBorder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerPolicy="strict-origin-when-cross-origin"
                        allowFullScreen></iframe>
                </div>
            </div>
        </div>
    );
}
