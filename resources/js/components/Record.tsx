import React, {useEffect, useState} from "react";

const Record : React.FC = () => {
    const [setData, data] = useState([])
    useEffect(() => {
        (async () => {
            try {
                await fetch('/records');
            } catch (err) {
                console.error(err);
            }
        })();
    }, []);
    return<div><img/></div>
}





export default Record;
