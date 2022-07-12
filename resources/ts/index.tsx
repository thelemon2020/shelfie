import React, {useState} from 'react';
import {AppShellMain} from "./AppShell/AppShell";

export const App = () => {
    const [child, setChild] = useState()
    return (
        <AppShellMain children={child}/>)
}
