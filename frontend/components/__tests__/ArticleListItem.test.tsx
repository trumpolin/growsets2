import { render, screen } from "@testing-library/react";
import ArticleListItem from "../ArticleListItem";

describe("ArticleListItem", () => {
  it("renders article title", () => {
    render(
      <ArticleListItem
        article={{ id: "1", title: "My Article" }}
        onToggle={jest.fn()}
      />,
    );
    expect(screen.getByText("My Article")).toBeInTheDocument();
    expect(screen.getByText("Ins Set")).toBeInTheDocument();
  });
});
