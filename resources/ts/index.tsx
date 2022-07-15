import React, {useState} from 'react';
import {AppShellMain} from "./AppShell/AppShell";
import {ColorScheme, ColorSchemeProvider, MantineProvider} from "@mantine/core";
import {ModalsProvider} from '@mantine/modals';
import {EnvStateProvider} from "./Context/EnvStateContext";


export const App = () => {
    const [colorScheme, setColorScheme] = useState<ColorScheme>('light');
    const toggleColorScheme = (value?: ColorScheme) =>
        setColorScheme(value || (colorScheme === 'dark' ? 'light' : 'dark'));

    return (
        <ColorSchemeProvider colorScheme={colorScheme} toggleColorScheme={toggleColorScheme}>
            <MantineProvider theme={{colorScheme}} withGlobalStyles withNormalizeCSS>
                <ModalsProvider>
                    <EnvStateProvider>
                        <AppShellMain/>
                    </EnvStateProvider>
                </ModalsProvider>
            </MantineProvider>
        </ColorSchemeProvider>)
}
