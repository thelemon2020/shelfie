import React, {useState} from 'react';
import {Bulb, MoonStars, Sun} from 'tabler-icons-react'
import {
    ActionIcon,
    AppShell,
    Burger,
    Button,
    Group,
    Header,
    MediaQuery,
    Navbar,
    Space,
    Text,
    useMantineColorScheme,
    useMantineTheme,
} from '@mantine/core';
import NowPlayingSection from "../NowPlaying";
import CollectionSection from "../Collection";

export const AppShellMain = () => {
    const theme = useMantineTheme();
    const [opened, setOpened] = useState(false);
    const [showLights, setShowLights] = useState(false);
    const {colorScheme, toggleColorScheme} = useMantineColorScheme();
    const [child, setChild] = useState(<NowPlayingSection/>)

    return (
        <AppShell
            styles={{
                main: {
                    background: theme.colorScheme === 'dark' ? theme.colors.dark[8] : theme.colors.gray[0],
                },
            }}
            navbarOffsetBreakpoint='md'
            fixed
            navbar={
                <Navbar p="md" hiddenBreakpoint="md" hidden={!opened} width={{sm: 200, lg: 300}}>
                    <Text>Menu</Text>
                    <Space h="sm"/>
                    <Button radius="lg" fullWidth={false} onClick={() => setChild(<NowPlayingSection/>)}>Now
                        Playing</Button>
                    <Space h="sm"/>
                    <Button radius="lg" onClick={() => setChild(<CollectionSection/>)}>Collection</Button>
                    <Space h="sm"/>
                    <Button radius="lg">Stats</Button>
                    <Space h="sm"/>
                    <Button radius="lg">Settings</Button>
                </Navbar>
            }
            aside={(showLights &&
                <MediaQuery smallerThan="sm" styles={{display: 'none'}}>
                    <Navbar p="md" hiddenBreakpoint="md" width={{sm: 200, lg: 300}}>
                        <Text>Light Control</Text>
                    </Navbar>
                </MediaQuery>)
            }
            header={
                <Header height={70} p="md">
                    <Group sx={{height: '100%'}} px={20} position="apart">
                        <div style={{display: 'flex', alignItems: 'center', height: '100%'}}>
                            <MediaQuery largerThan="md" styles={{display: 'none'}}>
                                <Burger
                                    opened={opened}
                                    onClick={() => {
                                        setOpened((o) => !o)
                                        setShowLights(false);
                                    }}
                                    size="sm"
                                    color={theme.colors.gray[6]}
                                    mr="xl"
                                />
                            </MediaQuery>

                            <Text>SHELFIE</Text>
                        </div>

                        <ActionIcon variant="default" onClick={() => {
                            setShowLights(!showLights)
                            setOpened(false);
                        }} size={30}>
                            <Bulb size={16}/>
                        </ActionIcon>

                        <ActionIcon variant="default" onClick={() => toggleColorScheme()} size={30}>
                            {colorScheme === 'dark' ? <Sun size={16}/> : <MoonStars size={16}/>}
                        </ActionIcon>
                    </Group>
                </Header>
            }
        >
            {child}
        </AppShell>
    );
}
