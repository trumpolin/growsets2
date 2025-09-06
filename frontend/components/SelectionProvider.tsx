"use client";
import { createContext, useContext, useState, ReactNode } from "react";

interface SelectionContextValue {
  selections: Record<string, string>;
  setSelection: (facet: string, value: string | null) => void;
}

const SelectionContext = createContext<SelectionContextValue | undefined>(
  undefined,
);

export function SelectionProvider({ children }: { children: ReactNode }) {
  const [selections, setSelections] = useState<Record<string, string>>({});

  const setSelection = (facet: string, value: string | null) => {
    setSelections((prev) => {
      const next = { ...prev };
      if (value === null) {
        delete next[facet];
      } else {
        next[facet] = value;
      }
      return next;
    });
  };

  return (
    <SelectionContext.Provider value={{ selections, setSelection }}>
      {children}
    </SelectionContext.Provider>
  );
}

export function useSelection() {
  const ctx = useContext(SelectionContext);
  if (!ctx)
    throw new Error("useSelection must be used within SelectionProvider");
  return ctx;
}
