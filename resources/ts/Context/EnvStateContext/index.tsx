import React, {useContext} from 'react'

const EnvStateContext = React.createContext<'local' | 'prod' | 'raspi'>('local');

const EnvStateProvider = ({ children }) => {
   const env = import.meta.env.VITE_APP_ENV;

   return (
        <EnvStateContext.Provider value={env}>
            {children}
        </EnvStateContext.Provider>
   )
};

const useEnvState = () => {
    const env = useContext(EnvStateContext);
    if (!env) {
        throw Error('EnvStateProvider is not given');
    }

    return env;
};

export { EnvStateProvider, useEnvState}
