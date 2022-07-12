import React, {useState} from 'react';
import {AppShell, Burger, Footer, Header, MediaQuery, Navbar, Text, useMantineTheme,} from '@mantine/core';

export const AppShellMain = ({children}) => {
    const theme = useMantineTheme();
    const [opened, setOpened] = useState(false);
    const [showLights, setShowLights] = useState(false);
    return (
        <AppShell
            styles={{
                main: {
                    background: theme.colorScheme === 'dark' ? theme.colors.dark[8] : theme.colors.gray[0],
                },
            }}
            navbarOffsetBreakpoint="sm"
            asideOffsetBreakpoint="sm"
            fixed
            navbar={
                <Navbar p="md" hiddenBreakpoint="sm" hidden={!opened} width={{sm: 200, lg: 300}}>
                    <Text>Menu</Text>
                </Navbar>
            }
            footer={(showLights && <Footer height={60} p="md">
                Light Control
            </Footer>)

            }
            header={
                <Header height={70} p="md">
                    <div style={{display: 'flex', alignItems: 'center', height: '100%'}}>
                        <MediaQuery largerThan="sm" styles={{display: 'none'}}>
                            <Burger
                                opened={opened}
                                onClick={() => setOpened((o) => !o)}
                                size="sm"
                                color={theme.colors.gray[6]}
                                mr="xl"
                            />
                        </MediaQuery>

                        <Text>SHELFIE</Text>
                    </div>
                </Header>
            }
        >
            {children}
        </AppShell>
    );
}
